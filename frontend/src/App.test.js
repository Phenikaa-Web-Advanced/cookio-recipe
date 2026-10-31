import { render, screen } from '@testing-library/react';
import App from './App';

test('renders Cookio brand navigation header', () => {
  render(<App />);
  const brandElement = screen.getByText(/Cookio/i);
  expect(brandElement).toBeInTheDocument();
});

test('renders Phenikaa Edition badge', () => {
  render(<App />);
  const badgeElement = screen.getByText(/Phenikaa Edition/i);
  expect(badgeElement).toBeInTheDocument();
});
