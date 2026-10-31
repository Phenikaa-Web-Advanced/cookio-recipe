import { Injectable, NotFoundException, ForbiddenException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository, Like } from 'typeorm';
import { Recipe, RecipeStatus } from '../../entities/recipe.entity';
import { CreateRecipeDto } from './dto/create-recipe.dto';
import { UserRole } from '../../entities/user.entity';

@Injectable()
export class RecipesService {
  constructor(
    @InjectRepository(Recipe)
    private readonly recipeRepository: Repository<Recipe>,
  ) {}

  async findAll(query?: { search?: string; category?: string; status?: RecipeStatus }) {
    const qb = this.recipeRepository
      .createQueryBuilder('recipe')
      .leftJoinAndSelect('recipe.author', 'author')
      .leftJoinAndSelect('recipe.comments', 'comments')
      .select([
        'recipe',
        'author.id',
        'author.username',
        'comments.id',
        'comments.content',
        'comments.rating',
        'comments.createdAt',
      ]);

    if (query?.status) {
      qb.andWhere('recipe.status = :status', { status: query.status });
    } else {
      qb.andWhere('recipe.status = :status', { status: RecipeStatus.APPROVED });
    }

    if (query?.category && query.category !== 'Tất cả') {
      qb.andWhere('recipe.category = :category', { category: query.category });
    }

    if (query?.search) {
      qb.andWhere('(recipe.title LIKE :search OR recipe.ingredients LIKE :search)', {
        search: `%${query.search}%`,
      });
    }

    qb.orderBy('recipe.createdAt', 'DESC');
    return qb.getMany();
  }

  async findOne(id: number) {
    const recipe = await this.recipeRepository.findOne({
      where: { id },
      relations: ['author', 'comments', 'comments.user'],
    });

    if (!recipe) {
      throw new NotFoundException(`Không tìm thấy công thức món ăn với mã #${id}`);
    }

    // Tăng lượt xem
    recipe.viewsCount += 1;
    await this.recipeRepository.save(recipe);

    return recipe;
  }

  async create(createRecipeDto: CreateRecipeDto, userId: number) {
    const recipe = this.recipeRepository.create({
      ...createRecipeDto,
      authorId: userId,
      status: RecipeStatus.APPROVED, // mặc định duyệt hoặc pending
    });
    return this.recipeRepository.save(recipe);
  }

  async update(id: number, updateData: Partial<CreateRecipeDto>, user: { id: number; role: UserRole }) {
    const recipe = await this.recipeRepository.findOne({ where: { id } });
    if (!recipe) {
      throw new NotFoundException(`Không tìm thấy công thức món ăn với mã #${id}`);
    }

    if (recipe.authorId !== user.id && user.role !== UserRole.ADMIN) {
      throw new ForbiddenException('Bạn không có quyền chỉnh sửa công thức này');
    }

    Object.assign(recipe, updateData);
    return this.recipeRepository.save(recipe);
  }

  async remove(id: number, user: { id: number; role: UserRole }) {
    const recipe = await this.recipeRepository.findOne({ where: { id } });
    if (!recipe) {
      throw new NotFoundException(`Không tìm thấy công thức món ăn với mã #${id}`);
    }

    if (recipe.authorId !== user.id && user.role !== UserRole.ADMIN) {
      throw new ForbiddenException('Bạn không có quyền xóa công thức này');
    }

    await this.recipeRepository.remove(recipe);
    return { success: true, message: 'Đã xóa công thức thành công' };
  }

  async likeRecipe(id: number) {
    const recipe = await this.recipeRepository.findOne({ where: { id } });
    if (!recipe) {
      throw new NotFoundException('Không tìm thấy công thức');
    }
    recipe.likesCount += 1;
    await this.recipeRepository.save(recipe);
    return { success: true, likesCount: recipe.likesCount };
  }
}
