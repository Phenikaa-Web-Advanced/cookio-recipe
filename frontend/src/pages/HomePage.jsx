import React, { useState, useEffect } from 'react';
import { Container, Row, Col, Form, InputGroup, Button, Spinner, Alert } from 'react-bootstrap';
import RecipeCard from '../components/RecipeCard';
import { recipeAPI } from '../services/api';

const CATEGORIES = ['Tất cả', 'Món chính', 'Món khai vị', 'Món canh', 'Món chay', 'Món Healthy', 'Đồ tráng miệng'];

export default function HomePage() {
  const [recipes, setRecipes] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [search, setSearch] = useState('');
  const [selectedCategory, setSelectedCategory] = useState('Tất cả');

  const fetchRecipes = async (keyword = '', category = 'Tất cả') => {
    try {
      setLoading(true);
      setError(null);
      const params = {};
      if (keyword.trim()) params.search = keyword.trim();
      if (category !== 'Tất cả') params.category = category;

      const res = await recipeAPI.getAll(params);
      setRecipes(res.data);
    } catch (err) {
      setError('Không thể tải danh sách món ăn từ máy chủ backend.');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchRecipes(search, selectedCategory);
  }, [selectedCategory]);

  const handleSearchSubmit = (e) => {
    e.preventDefault();
    fetchRecipes(search, selectedCategory);
  };

  const handleLike = async (id) => {
    try {
      await recipeAPI.like(id);
      setRecipes((prev) =>
        prev.map((r) => (r.id === id ? { ...r, likesCount: (r.likesCount || 0) + 1 } : r))
      );
    } catch (err) {
      console.error('Không thể thả tim:', err);
    }
  };

  return (
    <Container className="py-4">
      {/* Hero Banner */}
      <div className="p-4 p-md-5 mb-4 rounded-4 bg-light text-dark shadow-sm border border-light">
        <Row className="align-items-center">
          <Col md={7}>
            <h1 className="display-6 fw-bold text-danger mb-3">
              Mạng Xã Hội Ẩm Thực Bếp Gia Đình 🥗
            </h1>
            <p className="lead text-muted mb-4">
              Khám phá hơn 100+ công thức nấu ăn ngon chuẩn vị, tối ưu dinh dưỡng và cân bằng calo. 
              Giao diện tối ưu Usability - chỉ với dưới 4 lần bấm để tìm thấy công thức yêu thích!
            </p>
            <Form onSubmit={handleSearchSubmit}>
              <InputGroup size="lg" className="shadow-sm">
                <Form.Control
                  placeholder="Nhập tên món ăn hoặc nguyên liệu (vd: Phở bò, ức gà, sườn...)"
                  value={search}
                  onChange={(e) => setSearch(e.target.value)}
                  className="border-0"
                />
                <Button variant="danger" type="submit" className="px-4 fw-bold">
                  🔍 Tìm Kiếm
                </Button>
              </InputGroup>
            </Form>
          </Col>
          <Col md={5} className="d-none d-md-block text-center">
            <img
              src="https://images.unsplash.com/photo-1556910103-1c02745aae4d"
              alt="Cooking banner"
              className="img-fluid rounded-4 shadow"
              style={{ maxHeight: '260px', objectFit: 'cover', width: '100%' }}
            />
          </Col>
        </Row>
      </div>

      {/* Category Pills Filter */}
      <div className="d-flex flex-wrap gap-2 mb-4 pb-2 border-bottom">
        {CATEGORIES.map((cat) => (
          <Button
            key={cat}
            variant={selectedCategory === cat ? 'danger' : 'outline-secondary'}
            size="sm"
            className="rounded-pill px-3 py-1 fw-semibold"
            onClick={() => setSelectedCategory(cat)}
          >
            {cat}
          </Button>
        ))}
      </div>

      {/* Main Content List */}
      {loading ? (
        <div className="text-center py-5">
          <Spinner animation="border" variant="danger" role="status" />
          <p className="mt-2 text-secondary">Đang tải dữ liệu công thức từ NestJS API...</p>
        </div>
      ) : error ? (
        <Alert variant="warning" className="text-center rounded-3">
          {error}
        </Alert>
      ) : recipes.length === 0 ? (
        <div className="text-center py-5 bg-white rounded-4 shadow-sm">
          <p className="fs-5 text-muted">Không tìm thấy công thức phù hợp với từ khóa.</p>
          <Button variant="outline-danger" onClick={() => { setSearch(''); setSelectedCategory('Tất cả'); }}>
            Làm Mới Bộ Lọc
          </Button>
        </div>
      ) : (
        <Row xs={1} sm={2} md={3} lg={4} className="g-4">
          {recipes.map((recipe) => (
            <Col key={recipe.id}>
              <RecipeCard recipe={recipe} onLike={handleLike} />
            </Col>
          ))}
        </Row>
      )}
    </Container>
  );
}
