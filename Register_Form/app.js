import React, { useState, useEffect } from 'react';
import './App.css';

function App() {
  const [formData, setFormData] = useState({
    fname: '',
    lname: '',
    email: '',
    password: '',
    address: ''
  });

  const [data, setData] = useState([]); // State to store retrieved data

  useEffect(() => {
    fetchData(); // Fetch data when the component mounts
  }, []);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value
    });
  };

  const fetchData = async () => {
    try {
      const response = await fetch('http://localhost/lab8/dbReact.php'); // PHP script to fetch all data
      const json = await response.json();
      setData(json); // Store the fetched data in state
    } catch (error) {
      console.error("Error fetching data:", error);
    }
  };

  const handleSubmit = async (e) => {
    e.preventDefault(); // Prevents page refresh
    try {
      const response = await fetch('http://localhost/lab8/submitForm.php', { // PHP script to submit data
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData) // Send the form data as JSON
      });
      const result = await response.json();
      console.log("Form submitted:", result);
      fetchData(); // Fetch updated data after submission
    } catch (error) {
      console.error("Error submitting form:", error);
    }
  };

  return (
    <div className="form-container">
      <h2>Register</h2>
      <form onSubmit={handleSubmit}>
        <input
          type="text"
          id="fname"
          name="fname"
          placeholder="First Name"
          onChange={handleChange}
          value={formData.fname}
        />
        <input
          type="text"
          id="lname"
          name="lname"
          placeholder="Last Name"
          onChange={handleChange}
          value={formData.lname}
        />
        <input
          type="email"
          id="email"
          name="email"
          placeholder="Email"
          onChange={handleChange}
          value={formData.email}
        />
        <input
          type="password"
          id="password"
          name="password"
          placeholder="Password"
          onChange={handleChange}
          value={formData.password}
        />
        <input
          type="text"
          id="address"
          name="address"
          placeholder="Address"
          onChange={handleChange}
          value={formData.address}
        />
        
        <input type="submit" value="Submit" />
      </form>

      <h2>Registered Users</h2>
      <ul>
        {data.map((user, index) => (
          <li key={index}>
            {user.fname} {user.lname} - {user.email} - {user.address}
          </li>
        ))}
      </ul>
    </div>
  );
}

export default App;

