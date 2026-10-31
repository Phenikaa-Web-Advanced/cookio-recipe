import React from 'react';
import { Card, Badge, Button } from 'react-bootstrap';
import { Link } from 'react-router-dom';

export default function RecipeCard({ recipe, onLike }) {
  return (
    <Card className="h-100 shadow-sm border-0 rounded-4 overflow-hidden recipe-card">
      <div style={{ position: 'relative', height: '180px', overflow: 'hidden' }}>
        <Card.Img
          variant="top"
          src={recipe.imageUrl || 'https://images.unsplash.com/photo-1498837167922-ddd27525d352'}
          alt={recipe.title}
          style={{ objectFit: 'cover', height: '100%', width: '100%' }}
        />
        <Badge
          bg="dark"
          className="position-absolute top-0 start-0 m-3 px-3 py-2 opacity-75 rounded-pill"
        >
          {recipe.category || 'Món ngon'}
        </Badge>
      </div>
      <Card.Body className="d-flex flex-column justify-content-between p-3">
        <div>
          <Card.Title className="fs-6 fw-bold text-truncate mb-2" title={recipe.title}>
            {recipe.title}
          </Card.Title>
          <Card.Text className="text-muted small mb-3 text-truncate-2" style={{ maxHeight: '40px', overflow: 'hidden' }}>
            {recipe.description || 'Hương vị thơm ngon đậm đà, dễ dàng chế biến tại nhà.'}
          </Card.Text>
        </div>

        <div className="pt-2 border-top">
          <div className="d-flex justify-content-between align-items-center mb-2 small text-secondary">
            <span>⏱️ {recipe.cookingTime || '30p'}</span>
            <span>👥 {recipe.servings || '2-4 người'}</span>
            <span>👁️ {recipe.viewsCount || 0}</span>
          </div>

          <div className="d-flex gap-2">
            <Button
              as={Link}
              to={`/recipes/${recipe.id}`}
              variant="outline-primary"
              size="sm"
              className="w-100 rounded-pill fw-semibold"
            >
              Xem Chi Tiết
            </Button>
            <Button
              variant="outline-danger"
              size="sm"
              className="rounded-pill px-3"
              onClick={() => onLike(recipe.id)}
            >
              ❤️ {recipe.likesCount || 0}
            </Button>
          </div>
        </div>
      </Card.Body>
    </Card>
  );
}
