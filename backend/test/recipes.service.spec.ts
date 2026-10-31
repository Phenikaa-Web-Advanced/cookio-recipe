import { Test, TestingModule } from '@nestjs/testing';
import { getRepositoryToken } from '@nestjs/typeorm';
import { RecipesService } from '../src/modules/recipes/recipes.service';
import { Recipe, RecipeStatus } from '../src/entities/recipe.entity';

describe('RecipesService Unit Tests (Kiểm thử đơn vị công thức nấu ăn)', () => {
  let service: RecipesService;
  let mockRepository: any;

  const mockRecipeList: Partial<Recipe>[] = [
    {
      id: 1,
      title: 'Phở bò Hà Nội',
      category: 'Món chính',
      status: RecipeStatus.APPROVED,
      viewsCount: 10,
      likesCount: 5,
    },
    {
      id: 2,
      title: 'Salad ức gà Eat Clean',
      category: 'Món Healthy',
      status: RecipeStatus.APPROVED,
      viewsCount: 20,
      likesCount: 15,
    },
  ];

  beforeEach(async () => {
    mockRepository = {
      createQueryBuilder: jest.fn(() => ({
        leftJoinAndSelect: jest.fn().mockReturnThis(),
        select: jest.fn().mockReturnThis(),
        andWhere: jest.fn().mockReturnThis(),
        orderBy: jest.fn().mockReturnThis(),
        getMany: jest.fn().mockResolvedValue(mockRecipeList),
      })),
      findOne: jest.fn().mockImplementation(({ where: { id } }) => {
        const found = mockRecipeList.find((r) => r.id === id);
        return Promise.resolve(found || null);
      }),
      create: jest.fn().mockImplementation((dto) => dto),
      save: jest.fn().mockImplementation((recipe) => Promise.resolve({ id: 99, ...recipe })),
      remove: jest.fn().mockResolvedValue(true),
    };

    const module: TestingModule = await Test.createTestingModule({
      providers: [
        RecipesService,
        {
          provide: getRepositoryToken(Recipe),
          useValue: mockRepository,
        },
      ],
    }).compile();

    service = module.get<RecipesService>(RecipesService);
  });

  it('TC_RECIPE_01: Nên trả về danh sách công thức đã duyệt', async () => {
    const result = await service.findAll();
    expect(result).toHaveLength(2);
    expect(result[0].title).toBe('Phở bò Hà Nội');
  });

  it('TC_RECIPE_02: Nên xem chi tiết công thức và tăng lượt xem', async () => {
    const recipe = await service.findOne(1);
    expect(recipe).toBeDefined();
    expect(recipe.id).toBe(1);
    expect(recipe.viewsCount).toBe(11);
  });

  it('TC_RECIPE_03: Ném ngoại lệ NotFoundException nếu không tìm thấy ID', async () => {
    await expect(service.findOne(999)).rejects.toThrow();
  });
});
