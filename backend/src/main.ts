import { NestFactory } from '@nestjs/core';
import { ValidationPipe } from '@nestjs/common';
import { SwaggerModule, DocumentBuilder } from '@nestjs/swagger';
import helmet from 'helmet';
import { AppModule } from './app.module';
import { AllExceptionsFilter } from './common/filters/http-exception.filter';

async function bootstrap() {
  const app = await NestFactory.create(AppModule);

  // 1. Cấu hình bảo mật Helmet (Bảo vệ HTTP Headers)
  app.use(helmet());

  // 2. Cấu hình CORS chặt chẽ
  app.enableCors({
    origin: ['http://localhost:3000', 'http://127.0.0.1:3000'],
    methods: 'GET,HEAD,PUT,PATCH,POST,DELETE,OPTIONS',
    credentials: true,
  });

  // 3. Validation Pipe toàn cục (Sanitization & Whitelist DTO)
  app.useGlobalPipes(
    new ValidationPipe({
      whitelist: true,
      forbidNonWhitelisted: true,
      transform: true,
    }),
  );

  // 4. Exception Filter toàn cục (Bắt mọi lỗi và định dạng phản hồi chuẩn)
  app.useGlobalFilters(new AllExceptionsFilter());

  // 5. Cấu hình Swagger OpenAPI Documentation
  const config = new DocumentBuilder()
    .setTitle('Cookio Recipe API - Web Nâng Cao')
    .setDescription('Tài liệu OpenAPI / Swagger đặc tả các API nghiệp vụ hệ thống Cookio - ĐH Phenikaa')
    .setVersion('1.0.0')
    .addBearerAuth()
    .addTag('Authentication (Xác thực & Định danh)')
    .addTag('Recipes (Quản lý Công thức Nấu ăn)')
    .build();

  const document = SwaggerModule.createDocument(app, config);
  SwaggerModule.setup('api/docs', app, document);

  const port = process.env.PORT || 5000;
  await app.listen(port);
  console.log(`🚀 Backend NestJS đang chạy tại: http://localhost:${port}`);
  console.log(`📄 Swagger API Documentation tại: http://localhost:${port}/api/docs`);
}
bootstrap();
