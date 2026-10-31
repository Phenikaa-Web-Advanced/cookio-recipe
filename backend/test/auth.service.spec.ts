import { Test, TestingModule } from '@nestjs/testing';
import { getRepositoryToken } from '@nestjs/typeorm';
import { JwtService } from '@nestjs/jwt';
import { AuthService } from '../src/modules/auth/auth.service';
import { User, UserRole } from '../src/entities/user.entity';

describe('AuthService Unit Tests (Kiểm thử đơn vị xác thực người dùng)', () => {
  let service: AuthService;
  let mockUserRepo: any;
  let mockJwtService: any;

  beforeEach(async () => {
    mockUserRepo = {
      findOne: jest.fn(),
      createQueryBuilder: jest.fn(() => ({
        addSelect: jest.fn().mockReturnThis(),
        where: jest.fn().mockReturnThis(),
        getOne: jest.fn().mockResolvedValue({
          id: 1,
          username: 'chef_lan',
          password: '1',
          role: UserRole.USER,
        }),
      })),
      create: jest.fn().mockImplementation((dto) => dto),
      save: jest.fn().mockImplementation((user) => Promise.resolve({ id: 10, ...user })),
    };

    mockJwtService = {
      sign: jest.fn().mockReturnValue('mocked.jwt.token'),
    };

    const module: TestingModule = await Test.createTestingModule({
      providers: [
        AuthService,
        {
          provide: getRepositoryToken(User),
          useValue: mockUserRepo,
        },
        {
          provide: JwtService,
          useValue: mockJwtService,
        },
      ],
    }).compile();

    service = module.get<AuthService>(AuthService);
  });

  it('TC_AUTH_01: Đăng nhập thành công với mật khẩu đúng và trả về JWT Bearer Token', async () => {
    const res = await service.login({ username: 'chef_lan', password: '1' });
    expect(res).toBeDefined();
    expect(res.accessToken).toBe('mocked.jwt.token');
    expect(res.user.username).toBe('chef_lan');
  });

  it('TC_AUTH_02: Ném lỗi UnauthorizedException nếu sai mật khẩu', async () => {
    await expect(
      service.login({ username: 'chef_lan', password: 'wrongpassword' }),
    ).rejects.toThrow();
  });
});
