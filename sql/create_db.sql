-- Database: SmartBookingSystem
CREATE DATABASE SmartBookingSystem;
USE SmartBookingSystem;

-- Tables for the Movie Booking System
CREATE TABLE theaters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    t_rows INT NOT NULL,
    t_cols INT NOT NULL
);

CREATE TABLE shows (
    id INT AUTO_INCREMENT PRIMARY KEY,
    theater_id INT NOT NULL,
    movie_title VARCHAR(100) NOT NULL,
    showtime DATETIME NOT NULL,

    FOREIGN KEY (theater_id) REFERENCES theaters(id) ON DELETE CASCADE
);

CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    show_id INT NOT NULL,
    row INT NOT NULL,
    col INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (show_id) REFERENCES shows(id) ON DELETE CASCADE,
    UNIQUE (show_id, row, col) -- To prevent booking an already booked seat
);