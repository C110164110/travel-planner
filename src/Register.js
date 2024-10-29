// Register.js
import React, { useState } from 'react';
import axios from 'axios';

function Register() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [email, setEmail] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();
    await axios.post('http://localhost:5000/api/register', { username, password, email });
    alert('註冊成功！');
  };

  return (
    <form onSubmit={handleSubmit}>
      <input type="text" placeholder="用戶名" onChange={(e) => setUsername(e.target.value)} required />
      <input type="email" placeholder="電子郵件" onChange={(e) => setEmail(e.target.value)} required />
      <input type="password" placeholder="密碼" onChange={(e) => setPassword(e.target.value)} required />
      <button type="submit">註冊</button>
    </form>
  );
}

export default Register;
