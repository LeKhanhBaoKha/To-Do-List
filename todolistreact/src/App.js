import { BrowserRouter, Route, Routes } from "react-router-dom";
import "./App.css";
import Layout from "./pages/Layout";
import Register from "./pages/authentication/Register";
import React from "react";
import Index from "./pages/components/Index";
import Login from "./pages/authentication/Login";
function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route index element={<Login />} />
          <Route path="login" element={<Login />} />
          <Route path="register" element={<Register />} />
          <Route path="index" element={<Index />} />
        </Route>
      </Routes>
    </BrowserRouter>
  );
}

export default App;
