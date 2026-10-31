import { Entity, PrimaryGeneratedColumn, Column, CreateDateColumn, UpdateDateColumn, ManyToOne, OneToMany, JoinColumn } from 'typeorm';
import { User } from './user.entity';
import { Comment } from './comment.entity';

export enum RecipeStatus {
  PENDING = 'pending',
  APPROVED = 'approved',
  REJECTED = 'rejected',
}

@Entity('recipes')
export class Recipe {
  @PrimaryGeneratedColumn()
  id: number;

  @Column({ length: 200 })
  title: string;

  @Column({ type: 'text', nullable: true })
  description: string;

  @Column({ length: 50, default: 'Món chính' })
  category: string;

  @Column({ name: 'cooking_time', length: 50, default: '30 phút' })
  cookingTime: string;

  @Column({ length: 50, default: '2 - 4 người' })
  servings: string;

  @Column({ type: 'text' })
  ingredients: string;

  @Column({ type: 'text' })
  instructions: string;

  @Column({ type: 'text', nullable: true })
  tips: string;

  @Column({ type: 'int', nullable: true })
  calories: number;

  @Column({ name: 'image_url', length: 255, nullable: true })
  imageUrl: string;

  @Column({ name: 'author_id' })
  authorId: number;

  @ManyToOne(() => User, (user) => user.recipes, { onDelete: 'CASCADE' })
  @JoinColumn({ name: 'author_id' })
  author: User;

  @Column({ type: 'text', default: RecipeStatus.APPROVED })
  status: RecipeStatus;

  @Column({ name: 'views_count', default: 0 })
  viewsCount: number;

  @Column({ name: 'likes_count', default: 0 })
  likesCount: number;

  @OneToMany(() => Comment, (comment) => comment.recipe)
  comments: Comment[];

  @CreateDateColumn({ name: 'created_at' })
  createdAt: Date;

  @UpdateDateColumn({ name: 'updated_at' })
  updatedAt: Date;
}
