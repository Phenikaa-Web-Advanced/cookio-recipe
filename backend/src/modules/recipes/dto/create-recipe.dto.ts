import { IsNotEmpty, IsOptional, IsString, IsNumber } from 'class-validator';
import { ApiProperty, ApiPropertyOptional } from '@nestjs/swagger';

export class CreateRecipeDto {
  @ApiProperty({ example: 'Phở bò Hà Nội chuẩn vị truyền thống', description: 'Tiêu đề món ăn' })
  @IsNotEmpty({ message: 'Tiêu đề món ăn không được để trống' })
  @IsString()
  title: string;

  @ApiPropertyOptional({ example: 'Nước dùng trong vắt, đậm đà vị thảo mộc', description: 'Mô tả ngắn' })
  @IsOptional()
  @IsString()
  description?: string;

  @ApiPropertyOptional({ example: 'Món chính', description: 'Danh mục món ăn' })
  @IsOptional()
  @IsString()
  category?: string;

  @ApiPropertyOptional({ example: '45 phút', description: 'Thời gian chế biến' })
  @IsOptional()
  @IsString()
  cookingTime?: string;

  @ApiPropertyOptional({ example: '4 người', description: 'Khẩu phần' })
  @IsOptional()
  @IsString()
  servings?: string;

  @ApiProperty({ example: '500g bánh phở, 300g thịt bò tái, hành tây, gừng nướng, quế, hồi...', description: 'Nguyên liệu chi tiết' })
  @IsNotEmpty({ message: 'Danh sách nguyên liệu không được để trống' })
  @IsString()
  ingredients: string;

  @ApiProperty({ example: 'Bước 1: Ninh xương bò trong 4 tiếng.\nBước 2: Nướng gừng hành thơm nức...', description: 'Các bước nấu' })
  @IsNotEmpty({ message: 'Hướng dẫn nấu không được để trống' })
  @IsString()
  instructions: string;

  @ApiPropertyOptional({ example: 'Nên trần sơ bánh phở qua nước sôi', description: 'Mẹo nấu ngon' })
  @IsOptional()
  @IsString()
  tips?: string;

  @ApiPropertyOptional({ example: 450, description: 'Lượng calo ước tính' })
  @IsOptional()
  @IsNumber()
  calories?: number;

  @ApiPropertyOptional({ example: 'https://images.unsplash.com/photo-1582878826629-29b7ad1cdc43', description: 'URL hình ảnh' })
  @IsOptional()
  @IsString()
  imageUrl?: string;
}
