import React, { useState } from 'react';
import { Container, Card, Form, Button, Row, Col, Alert } from 'react-bootstrap';
import { useNavigate } from 'react-router-dom';
import { recipeAPI } from '../services/api';

export default function CreateRecipePage() {
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    title: '',
    category: 'Món chính',
    cookingTime: '30 phút',
    servings: '2 - 4 người',
    calories: 350,
    imageUrl: '',
    description: '',
    ingredients: '',
    instructions: '',
    tips: '',
  });
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData((prev) => ({
      ...prev,
      [name]: name === 'calories' ? Number(value) : value,
    }));
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);
    setError(null);

    try {
      await recipeAPI.create(formData);
      alert('Đăng công thức nấu ăn thành công!');
      navigate('/');
    } catch (err) {
      setError(err.response?.data?.message || 'Có lỗi xảy ra khi tạo công thức.');
    } finally {
      setLoading(false);
    }
  };

  return (
    <Container className="py-4" style={{ maxWidth: '800px' }}>
      <Card className="border-0 shadow rounded-4 p-4">
        <h3 className="fw-bold text-danger mb-3">➕ Chia Sẻ Công Thức Mới</h3>
        <p className="text-muted small mb-4">Lan tỏa hương vị gia đình cùng cộng đồng yêu bếp Cookio</p>

        {error && <Alert variant="danger">{error}</Alert>}

        <Form onSubmit={handleSubmit}>
          <Form.Group className="mb-3">
            <Form.Label className="fw-semibold">Tiêu đề món ăn *</Form.Label>
            <Form.Control
              name="title"
              placeholder="VD: Thịt kho tàu nước dừa miền Tây"
              value={formData.title}
              onChange={handleChange}
              required
            />
          </Form.Group>

          <Row className="mb-3">
            <Col md={6}>
              <Form.Group>
                <Form.Label className="fw-semibold">Danh mục</Form.Label>
                <Form.Select name="category" value={formData.category} onChange={handleChange}>
                  <option value="Món chính">Món chính</option>
                  <option value="Món khai vị">Món khai vị</option>
                  <option value="Món canh">Món canh</option>
                  <option value="Món chay">Món chay</option>
                  <option value="Món Healthy">Món Healthy</option>
                  <option value="Đồ tráng miệng">Đồ tráng miệng</option>
                </Form.Select>
              </Form.Group>
            </Col>
            <Col md={3}>
              <Form.Group>
                <Form.Label className="fw-semibold">Thời gian nấu</Form.Label>
                <Form.Control
                  name="cookingTime"
                  placeholder="30 phút"
                  value={formData.cookingTime}
                  onChange={handleChange}
                />
              </Form.Group>
            </Col>
            <Col md={3}>
              <Form.Group>
                <Form.Label className="fw-semibold">Calo ước tính</Form.Label>
                <Form.Control
                  type="number"
                  name="calories"
                  value={formData.calories}
                  onChange={handleChange}
                />
              </Form.Group>
            </Col>
          </Row>

          <Form.Group className="mb-3">
            <Form.Label className="fw-semibold">Link ảnh món ăn (URL)</Form.Label>
            <Form.Control
              name="imageUrl"
              placeholder="https://images.unsplash.com/photo-..."
              value={formData.imageUrl}
              onChange={handleChange}
            />
          </Form.Group>

          <Form.Group className="mb-3">
            <Form.Label className="fw-semibold">Mô tả ngắn</Form.Label>
            <Form.Control
              as="textarea"
              rows={2}
              name="description"
              placeholder="Giới thiệu nhanh nét đặc trưng của món..."
              value={formData.description}
              onChange={handleChange}
            />
          </Form.Group>

          <Form.Group className="mb-3">
            <Form.Label className="fw-semibold">Danh sách nguyên liệu *</Form.Label>
            <Form.Control
              as="textarea"
              rows={3}
              name="ingredients"
              placeholder="- 500g thịt ba chỉ&#10;- 4 quả trứng vịt&#10;- 1 trái dừa xiêm tươi"
              value={formData.ingredients}
              onChange={handleChange}
              required
            />
          </Form.Group>

          <Form.Group className="mb-3">
            <Form.Label className="fw-semibold">Các bước nấu chi tiết *</Form.Label>
            <Form.Control
              as="textarea"
              rows={4}
              name="instructions"
              placeholder="Bước 1: Sơ chế và ướp thịt...&#10;Bước 2: Thắng nước màu caramel..."
              value={formData.instructions}
              onChange={handleChange}
              required
            />
          </Form.Group>

          <Form.Group className="mb-4">
            <Form.Label className="fw-semibold">Mẹo nhỏ (Tùy chọn)</Form.Label>
            <Form.Control
              name="tips"
              placeholder="Mẹo nhỏ để món ăn ngon tròn vị..."
              value={formData.tips}
              onChange={handleChange}
            />
          </Form.Group>

          <Button variant="danger" type="submit" className="w-100 py-2 fw-bold rounded-pill" disabled={loading}>
            {loading ? 'Đang xuất bản công thức...' : 'Xuất Bản Công Thức'}
          </Button>
        </Form>
      </Card>
    </Container>
  );
}
