// Login.js
import React, { useState } from 'react';
import axios from 'axios';

function Login() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      const response = await axios.post('http://localhost:5000/api/login', { username, password });
      alert('登錄成功！');
      console.log(response.data.token);
    } catch (error) {
      alert('登錄失敗！');
    }
  };

  return (
    <form onSubmit={handleSubmit}>
      <input type="text" placeholder="用戶名" onChange={(e) => setUsername(e.target.value)} required />
      <input type="password" placeholder="密碼" onChange={(e) => setPassword(e.target.value)} required />
      <button type="submit">登錄</button>
    </form>
  );
}

export default Login;
