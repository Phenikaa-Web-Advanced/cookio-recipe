import { Controller, Get, Post, Put, Delete, Body, Param, Query, UseGuards, Request, ParseIntPipe } from '@nestjs/common';
import { ApiTags, ApiOperation, ApiResponse, ApiBearerAuth, ApiQuery } from '@nestjs/swagger';
import { RecipesService } from './recipes.service';
import { CreateRecipeDto } from './dto/create-recipe.dto';
import { AuthGuard } from '@nestjs/passport';
import { RecipeStatus } from '../../entities/recipe.entity';

@ApiTags('Recipes (Quản lý Công thức Nấu ăn)')
@Controller('api/recipes')
export class RecipesController {
  constructor(private readonly recipesService: RecipesService) {}

  @Get()
  @ApiOperation({ summary: 'Lấy danh sách công thức (có hỗ trợ tìm kiếm và lọc danh mục)' })
  @ApiQuery({ name: 'search', required: false, description: 'Từ khóa tìm kiếm theo tên món hoặc nguyên liệu' })
  @ApiQuery({ name: 'category', required: false, description: 'Lọc theo danh mục món ăn' })
  @ApiResponse({ status: 200, description: 'Danh sách công thức trả về thành công.' })
  async findAll(
    @Query('search') search?: string,
    @Query('category') category?: string,
  ) {
    return this.recipesService.findAll({ search, category, status: RecipeStatus.APPROVED });
  }

  @Get(':id')
  @ApiOperation({ summary: 'Xem chi tiết một công thức theo ID (kèm bình luận và tác giả)' })
  @ApiResponse({ status: 200, description: 'Chi tiết công thức.' })
  @ApiResponse({ status: 404, description: 'Không tìm thấy công thức.' })
  async findOne(@Param('id', ParseIntPipe) id: number) {
    return this.recipesService.findOne(id);
  }

  @UseGuards(AuthGuard('jwt'))
  @Post()
  @ApiBearerAuth()
  @ApiOperation({ summary: 'Tạo mới một công thức nấu ăn (Yêu cầu đăng nhập)' })
  @ApiResponse({ status: 201, description: 'Tạo công thức thành công.' })
  @ApiResponse({ status: 401, description: 'Chưa đăng nhập.' })
  async create(@Body() createRecipeDto: CreateRecipeDto, @Request() req) {
    return this.recipesService.create(createRecipeDto, req.user.id);
  }

  @UseGuards(AuthGuard('jwt'))
  @Put(':id')
  @ApiBearerAuth()
  @ApiOperation({ summary: 'Cập nhật công thức theo ID (Chính chủ hoặc Admin)' })
  @ApiResponse({ status: 200, description: 'Cập nhật thành công.' })
  async update(
    @Param('id', ParseIntPipe) id: number,
    @Body() updateRecipeDto: Partial<CreateRecipeDto>,
    @Request() req,
  ) {
    return this.recipesService.update(id, updateRecipeDto, req.user);
  }

  @UseGuards(AuthGuard('jwt'))
  @Delete(':id')
  @ApiBearerAuth()
  @ApiOperation({ summary: 'Xóa công thức theo ID (Chính chủ hoặc Admin)' })
  @ApiResponse({ status: 200, description: 'Xóa thành công.' })
  async remove(@Param('id', ParseIntPipe) id: number, @Request() req) {
    return this.recipesService.remove(id, req.user);
  }

  @Post(':id/like')
  @ApiOperation({ summary: 'Thả tim/Thích công thức nấu ăn' })
  @ApiResponse({ status: 200, description: 'Thả tim thành công.' })
  async like(@Param('id', ParseIntPipe) id: number) {
    return this.recipesService.likeRecipe(id);
  }
}
