import React from 'react';
import { Navbar, Nav, Container, Button, Badge } from 'react-bootstrap';
import { Link, useNavigate } from 'react-router-dom';

export default function AppNavbar({ user, onLogout }) {
  const navigate = useNavigate();

  return (
    <Navbar bg="white" expand="lg" className="border-bottom sticky-top shadow-sm py-2">
      <Container>
        <Navbar.Brand as={Link} to="/" className="fw-bold text-danger fs-3 d-flex align-items-center">
          <span className="me-2">🍳</span> Cookio
          <Badge bg="warning" text="dark" className="ms-2 fs-6">Phenikaa Edition</Badge>
        </Navbar.Brand>
        <Navbar.Toggle aria-controls="cookio-navbar-nav" />
        <Navbar.Collapse id="cookio-navbar-nav">
          <Nav className="me-auto ms-3">
            <Nav.Link as={Link} to="/">Trang Chủ</Nav.Link>
            <Nav.Link as={Link} to="/recipes">Khám Phá Món Ngon</Nav.Link>
            {user && (
              <Nav.Link as={Link} to="/create-recipe">
                <span className="text-success fw-semibold">➕ Đăng Công Thức</span>
              </Nav.Link>
            )}
          </Nav>
          <Nav className="align-items-center">
            {user ? (
              <div className="d-flex align-items-center gap-2">
                <span className="text-secondary small">
                  Xin chào, <strong className="text-dark">{user.username}</strong>
                  {user.role === 'admin' && <Badge bg="danger" className="ms-1">Admin</Badge>}
                </span>
                <Button variant="outline-danger" size="sm" onClick={onLogout}>
                  Đăng Xuất
                </Button>
              </div>
            ) : (
              <div className="d-flex gap-2">
                <Button variant="outline-primary" size="sm" onClick={() => navigate('/login')}>
                  Đăng Nhập
                </Button>
                <Button variant="danger" size="sm" onClick={() => navigate('/register')}>
                  Đăng Ký
                </Button>
              </div>
            )}
          </Nav>
        </Navbar.Collapse>
      </Container>
    </Navbar>
  );
}
