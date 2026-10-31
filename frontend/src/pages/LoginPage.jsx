import React, { useState } from 'react';
import { Container, Card, Form, Button, Alert } from 'react-bootstrap';
import { useNavigate, Link } from 'react-router-dom';
import { authAPI } from '../services/api';

export default function LoginPage({ onLoginSuccess }) {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [error, setError] = useState(null);
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError(null);
    setLoading(true);

    try {
      const res = await authAPI.login({ username, password });
      const { accessToken, user } = res.data;
      localStorage.setItem('cookio_token', accessToken);
      localStorage.setItem('cookio_user', JSON.stringify(user));
      onLoginSuccess(user);
      navigate('/');
    } catch (err) {
      setError(err.response?.data?.message || 'Đăng nhập thất bại. Vui lòng kiểm tra lại!');
    } finally {
      setLoading(false);
    }
  };

  return (
    <Container className="py-5" style={{ maxWidth: '450px' }}>
      <Card className="border-0 shadow rounded-4 p-4">
        <Card.Body>
          <div className="text-center mb-4">
            <h3 className="fw-bold text-danger">Đăng Nhập Cookio</h3>
            <p className="text-muted small">Cổng xác thực an toàn chuẩn JWT Token</p>
          </div>

          {error && <Alert variant="danger" className="py-2 small">{error}</Alert>}

          <Form onSubmit={handleSubmit}>
            <Form.Group className="mb-3">
              <Form.Label className="small fw-semibold">Tên đăng nhập</Form.Label>
              <Form.Control
                type="text"
                placeholder="Nhập username (vd: admin1111)"
                value={username}
                onChange={(e) => setUsername(e.target.value)}
                required
              />
            </Form.Group>

            <Form.Group className="mb-4">
              <Form.Label className="small fw-semibold">Mật khẩu</Form.Label>
              <Form.Control
                type="password"
                placeholder="Nhập mật khẩu (vd: 1)"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
                required
              />
            </Form.Group>

            <Button variant="danger" type="submit" className="w-100 py-2 fw-bold rounded-pill" disabled={loading}>
              {loading ? 'Đang xử lý...' : 'Đăng Nhập Ngay'}
            </Button>
          </Form>

          <div className="text-center mt-4 pt-3 border-top small text-muted">
            Chưa có tài khoản?{' '}
            <Link to="/register" className="text-danger fw-semibold">
              Đăng ký thành viên mới
            </Link>
          </div>
        </Card.Body>
      </Card>
    </Container>
  );
}
