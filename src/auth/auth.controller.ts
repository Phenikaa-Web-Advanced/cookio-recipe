import { Controller, Post, Get, Body, Headers } from '@nestjs/common';
import { AuthService } from './auth.service';

@Controller('auth')
export class AuthController {
  constructor(private readonly authService: AuthService) {}

  @Post('register')
  async register(@Body() body: any) {
    return this.authService.register(body.username, body.password);
  }

  @Post('login')
  async login(@Body() body: any) {
    return this.authService.login(body.username, body.password);
  }

  @Get('profile')
  async getProfile(@Headers('authorization') authHeader: string) {
    return this.authService.getProfile(authHeader);
  }

  @Get('users')
  async getUsers() {
    return this.authService.getAllUsers();
  }
}