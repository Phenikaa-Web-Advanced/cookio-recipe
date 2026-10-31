import { Module } from '@nestjs/common';
import { TypeOrmModule } from '@nestjs/typeorm';
import { User } from './entities/user.entity';
import { Recipe } from './entities/recipe.entity';
import { Comment } from './entities/comment.entity';
import { AuthModule } from './modules/auth/auth.module';
import { RecipesModule } from './modules/recipes/recipes.module';

@Module({
  imports: [
    TypeOrmModule.forRoot({
      type: (process.env.DB_TYPE as any) || 'sqlite',
      database: process.env.DB_DATABASE || 'cookio.sqlite',
      host: process.env.DB_HOST || 'localhost',
      port: Number(process.env.DB_PORT) || 3306,
      username: process.env.DB_USER || 'root',
      password: process.env.DB_PASSWORD || '',
      entities: [User, Recipe, Comment],
      synchronize: true, // Auto-create tables for academic demo
      logging: false,
    }),
    AuthModule,
    RecipesModule,
  ],
})
export class AppModule {}
