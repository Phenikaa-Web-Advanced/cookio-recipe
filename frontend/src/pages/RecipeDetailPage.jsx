import React, { useState, useEffect } from 'react';
import { Container, Row, Col, Card, Badge, Button, Spinner, Alert, ListGroup } from 'react-bootstrap';
import { useParams, useNavigate } from 'react-router-dom';
import { recipeAPI } from '../services/api';

export default function RecipeDetailPage() {
  const { id } = useParams();
  const navigate = useNavigate();
  const [recipe, setRecipe] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchDetail = async () => {
      try {
        setLoading(true);
        const res = await recipeAPI.getById(id);
        setRecipe(res.data);
      } catch (err) {
        setError('Không thể tìm thấy chi tiết công thức này.');
      } finally {
        setLoading(false);
      }
    };
    fetchDetail();
  }, [id]);

  if (loading) {
    return (
      <Container className="text-center py-5">
        <Spinner animation="border" variant="danger" />
        <p className="mt-2 text-muted">Đang tải chi tiết món ăn...</p>
      </Container>
    );
  }

  if (error || !recipe) {
    return (
      <Container className="py-5">
        <Alert variant="warning" className="text-center">
          {error || 'Công thức không tồn tại'}
        </Alert>
        <div className="text-center">
          <Button variant="outline-primary" onClick={() => navigate('/')}>Quay lại Trang Chủ</Button>
        </div>
      </Container>
    );
  }

  return (
    <Container className="py-4" style={{ maxWidth: '900px' }}>
      <Button variant="link" className="text-decoration-none text-secondary p-0 mb-3" onClick={() => navigate(-1)}>
        ← Quay lại danh sách
      </Button>

      <Card className="border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div style={{ maxHeight: '380px', overflow: 'hidden' }}>
          <Card.Img
            src={recipe.imageUrl || 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c'}
            alt={recipe.title}
            style={{ objectFit: 'cover', width: '100%', height: '100%' }}
          />
        </div>
        <Card.Body className="p-4">
          <div className="d-flex justify-content-between align-items-start mb-2">
            <Badge bg="danger" className="px-3 py-2 fs-6 rounded-pill">
              {recipe.category || 'Món chính'}
            </Badge>
            <span className="text-muted small">
              Tác giả: <strong>{recipe.author?.username || 'Đầu bếp Cookio'}</strong>
            </span>
          </div>

          <h2 className="fw-bold mb-3">{recipe.title}</h2>
          <p className="text-muted lead fs-6 mb-4">{recipe.description}</p>

          <Row className="text-center bg-light rounded-3 py-3 mb-4 g-2">
            <Col xs={4}>
              <div className="small text-muted">Thời gian nấu</div>
              <div className="fw-bold">⏱️ {recipe.cookingTime || '30 phút'}</div>
            </Col>
            <Col xs={4} className="border-start border-end">
              <div className="small text-muted">Khẩu phần</div>
              <div className="fw-bold">👥 {recipe.servings || '2-4 người'}</div>
            </Col>
            <Col xs={4}>
              <div className="small text-muted">Năng lượng</div>
              <div className="fw-bold text-success">🔥 {recipe.calories ? `${recipe.calories} kcal` : 'Tiêu chuẩn'}</div>
            </Col>
          </Row>

          <h4 className="fw-bold text-danger mb-3">🛒 Nguyên Liệu Chuẩn Bị</h4>
          <Card className="bg-light border-0 mb-4 p-3 rounded-3">
            <div style={{ whiteSpace: 'pre-line' }} className="text-dark">
              {recipe.ingredients}
            </div>
          </Card>

          <h4 className="fw-bold text-danger mb-3">👩‍🍳 Các Bước Thực Hiện</h4>
          <Card className="border-0 shadow-sm mb-4 p-3 rounded-3">
            <div style={{ whiteSpace: 'pre-line', lineHeight: '1.8' }}>
              {recipe.instructions}
            </div>
          </Card>

          {recipe.tips && (
            <Alert variant="warning" className="rounded-3">
              <strong>💡 Mẹo nhỏ từ đầu bếp: </strong> {recipe.tips}
            </Alert>
          )}
        </Card.Body>
      </Card>
    </Container>
  );
}
