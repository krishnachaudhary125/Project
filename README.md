# Project
4th Semester


Database for games
CREATE TABLE games (
    game_id INT AUTO_INCREMENT PRIMARY KEY,
    game_name VARCHAR(255) NOT NULL,
    game_developer VARCHAR(255) NOT NULL,
    description TEXT,
    category_id INT NOT NULL,
    release_date DATE NOT NULL,
    game_price DECIMAL(10, 2) NOT NULL,
    game_keyword TEXT,
    game_photo VARCHAR(255),
    game_video VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_category FOREIGN KEY (category_id) REFERENCES category(category_id)
);