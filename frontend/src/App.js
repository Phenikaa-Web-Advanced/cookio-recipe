import React, { useState, useEffect } from 'react';
import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import AppNavbar from './components/Navbar';
import HomePage from './pages/HomePage';
import RecipeDetailPage from './pages/RecipeDetailPage';
import CreateRecipePage from './pages/CreateRecipePage';
import LoginPage from './pages/LoginPage';

function App() {
  const [currentUser, setCurrentUser] = useState(null);

  useEffect(() => {
    const savedUser = localStorage.getItem('cookio_user');
    if (savedUser) {
      try {
        setCurrentUser(JSON.parse(savedUser));
      } catch (e) {
        localStorage.removeItem('cookio_user');
      }
    }
  }, []);

  const handleLogout = () => {
    localStorage.removeItem('cookio_token');
    localStorage.removeItem('cookio_user');
    setCurrentUser(null);
    window.location.href = '/';
  };

  return (
    <Router>
      <div className="min-vh-100 d-flex flex-column bg-light text-dark">
        <AppNavbar user={currentUser} onLogout={handleLogout} />
        <main className="flex-grow-1">
          <Routes>
            <Route path="/" element={<HomePage />} />
            <Route path="/recipes" element={<HomePage />} />
            <Route path="/recipes/:id" element={<RecipeDetailPage />} />
            <Route path="/create-recipe" element={<CreateRecipePage />} />
            <Route path="/login" element={<LoginPage onLoginSuccess={setCurrentUser} />} />
            <Route path="/register" element={<LoginPage onLoginSuccess={setCurrentUser} />} />
          </Routes>
        </main>
        <footer className="bg-white border-top py-4 text-center text-muted small">
          <div className="container">
            <p className="mb-1 fw-bold text-dark">© 2026 COOKIO - Nền Tảng Học Tập & Chia Sẻ Ẩm Thực Gia Đình</p>
            <p className="mb-0">Dự án Đồ Án Môn Học Lập Trình Web Nâng Cao - Trường Đại học Phenikaa</p>
          </div>
        </footer>
      </div>
    </Router>
  );
}

export default App;
