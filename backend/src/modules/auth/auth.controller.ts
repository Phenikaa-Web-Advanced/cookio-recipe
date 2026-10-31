import { Controller, Post, Body, Get, UseGuards, Request } from '@nestjs/common';
import { ApiTags, ApiOperation, ApiResponse, ApiBearerAuth } from '@nestjs/swagger';
import { AuthService } from './auth.service';
import { LoginDto } from './dto/login.dto';
import { RegisterDto } from './dto/register.dto';
import { AuthGuard } from '@nestjs/passport';

@ApiTags('Authentication (Xác thực & Định danh)')
@Controller('api/auth')
export class AuthController {
  constructor(private readonly authService: AuthService) {}

  @Post('register')
  @ApiOperation({ summary: 'Đăng ký tài khoản người dùng mới' })
  @ApiResponse({ status: 201, description: 'Đăng ký tài khoản thành công.' })
  @ApiResponse({ status: 409, description: 'Tên đăng nhập đã tồn tại.' })
  async register(@Body() registerDto: RegisterDto) {
    return this.authService.register(registerDto);
  }

  @Post('login')
  @ApiOperation({ summary: 'Đăng nhập hệ thống và lấy JWT Bearer Token' })
  @ApiResponse({ status: 200, description: 'Đăng nhập thành công, trả về JWT Token.' })
  @ApiResponse({ status: 401, description: 'Sai tên đăng nhập hoặc mật khẩu.' })
  async login(@Body() loginDto: LoginDto) {
    return this.authService.login(loginDto);
  }

  @UseGuards(AuthGuard('jwt'))
  @Get('profile')
  @ApiBearerAuth()
  @ApiOperation({ summary: 'Lấy thông tin cá nhân của tài khoản đang đăng nhập' })
  @ApiResponse({ status: 200, description: 'Thông tin tài khoản xác thực hợp lệ.' })
  @ApiResponse({ status: 401, description: 'Chưa đăng nhập hoặc Token không hợp lệ.' })
  async getProfile(@Request() req) {
    return this.authService.getProfile(req.user.id);
  }
}
