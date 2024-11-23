--creating table user
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `birth_month` int(11) DEFAULT NULL,
  `birth_date` int(11) DEFAULT NULL,
  `birth_year` int(11) DEFAULT NULL,
  `mobile_number` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL
)
--creating posts table
CREATE TABLE posts (
    post_id INT AUTO_INCREMENT PRIMARY KEY, 
    user_id INT NOT NULL, 
    post_img VARCHAR(255), 
    post_like INT DEFAULT 0,
    post_share INT DEFAULT 0, 
    post_heading VARCHAR(255),
    post_description TEXT, 
    upload_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(user_id) 
);

--creating table for comments
CREATE TABLE comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY, 
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    comment_text TEXT NOT NULL, 
    comment_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 
    CONSTRAINT fk_post FOREIGN KEY (post_id) REFERENCES posts(post_id) ON DELETE CASCADE,
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);
