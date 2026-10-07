import { Injectable, UnauthorizedException } from '@nestjs/common';
import { JwtService } from '@nestjs/jwt';

@Injectable()
export class AuthService {
  private users: any[] = [];

  constructor(private readonly jwtService: JwtService) {}

  async register(username: string, pass: string) {
    const newUser = { id: Date.now(), username, password: pass };
    this.users.push(newUser);
    return { message: 'Đăng ký tài khoản thành công', user: { username } };
  }

  async login(username: string, pass: string) {
    const user = this.users.find((u) => u.username === username && u.password === pass);
    if (!user) {
      throw new UnauthorizedException('Sai tài khoản hoặc mật khẩu!');
    }

    const payload = { sub: user.id, username: user.username };
    const access_token = this.jwtService.sign(payload);

    return {
      access_token,
      message: 'Đăng nhập thành công!',
    };
  }

  async getProfile(authHeader: string) {
    if (!authHeader || !authHeader.startsWith('Bearer ')) {
      throw new UnauthorizedException('Thiếu JWT Token trong Header!');
    }

    const token = authHeader.split(' ')[1];
    try {
      const decoded = this.jwtService.verify(token);
      return {
        message: 'Xác thực JWT thành công (Authorized)!',
        user: decoded,
      };
    } catch (error) {
      throw new UnauthorizedException('JWT Token không hợp lệ hoặc đã hết hạn!');
    }
  }

  async getAllUsers() {
    return this.users;
  }
}