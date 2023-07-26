CREATE DATABASE IF NOT EXISTS WebBlog;

USE WebBlog;

CREATE TABLE IF NOT EXISTS users (
  id INT NOT NULL AUTO_INCREMENT,
  first_name VARCHAR(50) NOT NULL,
  last_name VARCHAR(50) NOT NULL,
  username VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL,
  avatar VARCHAR(255) DEFAULT NULL,
  is_admin TINYINT(1) DEFAULT 0,
  PRIMARY KEY (id)
);


CREATE TABLE IF NOT EXISTS categories (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS posts (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  author_id INT NOT NULL,
  category_id INT NOT NULL,
  post_date DATETIME NOT NULL,
  post_text TEXT NOT NULL,
  post_image VARCHAR(255),
  PRIMARY KEY (id),
  FOREIGN KEY (author_id) REFERENCES users(id),
  FOREIGN KEY (category_id) REFERENCES categories(id)
  ON UPDATE CASCADE ON DELETE CASCADE
);



INSERT INTO `users` (`first_name`, `last_name`, `username`, `email`, `password`, `avatar`,`is_admin`) VALUES
('salama', 'hassani', 'salama', 'salama@example.com', 'ae5077d95443b1de27a5a44d27b05162ee36a8ca9bacad7500fa40b3739b8870', 'images/face_1.jpg','1'),
('ana', 'santa', 'ana', 'ana@example.com', '24d4b96f58da6d4a8512313bbd02a28ebf0ca95dec6e4c86ef78ce7f01e788ac', 'images/face_2.jpg','0'),
('hugo', 'fanny', 'hugo', 'hugo@example.com', '0478721f1106c2a631a90181bac7efc77767a3903eb9220687bff8a14e940fa7', 'images/face_3.jpg','0'),
('mar', 'montes', 'mar', 'mar@gmail.com', '51609286fb7f6089e0a0a418355949c791e84870ae2523093ba00bb3ecff7f8e', 'images/face_4.jpg','0'),
('fatima', 'tribak', 'fatima', 'fatima@gmail.com', '10c932ece8048a7386160bf1463a4db09c26613801369bd5d1d00a7ed6c001dd', 'images/face_5.jpg','1'),

INSERT INTO categories (name) VALUES
('Nature'),
('Animals'),
('Food'),
('Sports'),
('Thechnology'),
('Fashion');

INSERT INTO posts (title, author_id, category_id, post_date, post_text, post_image) VALUES
('OctoTales: Diving into the Enigmatic World of the Octopus', 1, 2, DATE_FORMAT(NOW(), '%W, %M %e, %Y. %l:%i %p'), "The octopus is a fascinating sea creature known for its eight long and flexible arms that are lined with suction cups. They are highly intelligent animals with complex nervous systems that allow them to problem-solve and even exhibit play behavior. Octopuses are also known for their ability to camouflage themselves, changing their color and texture to blend into their surroundings. They are primarily solitary creatures and can be found in all of the world's oceans, from shallow tidal pools to the deep sea. Their diet consists mainly of crustaceans, small fish, and mollusks. Despite their unique characteristics and abilities, octopuses face threats such as overfishing and habitat destruction due to human activities.", 'octupus.jpg'),
('Game, Set, Blog: Exploring the Thrilling World of Tennis', 2, 4, DATE_FORMAT(NOW(), '%W, %M %e, %Y. %l:%i %p'), "Tennis is a popular racquet sport that can be played individually against a single opponent (singles) or in teams of two against another team (doubles). The objective of the game is to hit the ball over a net and into the opponent's side of the court, with the goal of making it difficult for the opponent to return the ball. Points are awarded when the opponent fails to return the ball within the boundaries of the court or hits the ball out of bounds. Tennis requires speed, agility, and precision, as well as strategic thinking and mental focus. It is played on a variety of surfaces, including grass, clay, and hard court, each with its unique characteristics that can affect gameplay. Tennis has a rich history and has produced many legendary players who have become household names, such as Roger Federer, Rafael Nadal, and Serena Williams. It is a popular recreational activity and a highly competitive professional sport with major tournaments, such as the Grand Slam events, drawing huge audiences from around the world.", 'tenis.jpg'),
('The Delightful Versatility of Salmon: A Stellar Addition to Your Plate', 1, 3, DATE_FORMAT(NOW(), '%W, %M %e, %Y. %l:%i %p'),"Salmon is a type of fish that is widely known for its delicious taste and nutritional benefits. It is anadromous, meaning that it spends most of its life in the ocean and then migrates upstream to spawn in freshwater rivers and streams. Salmon is rich in omega-3 fatty acids, high-quality protein, and vitamins such as B12 and D, making it a healthy food choice. The flesh of salmon can range in color from pink to red, depending on the species and diet. Some of the most common species of salmon include Chinook, Coho, Sockeye, and Atlantic. Salmon is a popular ingredient in many dishes, including sushi, grilled salmon fillets, smoked salmon, and salmon burgers. Unfortunately, overfishing and habitat destruction have led to declining salmon populations in some areas, prompting conservation efforts to protect and restore their habitats and populations.", 'salmon.jpg'),
('Feathers and Flight: Unveiling the Fascinating World of Birds', 3, 2, DATE_FORMAT(NOW(), '%W, %M %e, %Y. %l:%i %p'),"Birds, the enchanting creatures of the sky, captivate us with their vibrant plumage, melodious songs, and remarkable ability to soar through the air. With a diverse range of species found across the globe, these winged wonders have intrigued humans for centuries.From the majestic eagles soaring high above the mountains to the tiny hummingbirds hovering delicately around nectar-rich flowers, each bird possesses its own unique characteristics and behaviors. Their adaptations for flight, such as lightweight bodies, hollow bones, and intricate feathers, allow them to navigate the skies with grace and precision.One of the most awe-inspiring aspects of birds is their captivating plumage. Whether it's the brilliant blue of a peacock's tail feathers, the vibrant hues of a toucan's bill, or the striking patterns of a bird of paradise, their colors and patterns are a testament to nature's artistic brilliance. Feathers not only provide insulation and aid in flight but also play a crucial role in courtship displays and species recognition.", 'bird.jpg'),
('Unleashing Style: Exploring the Ever-Evolving World of Fashion', 4, 6, DATE_FORMAT(NOW(), '%W, %M %e, %Y. %l:%i %p'),"Fashion is a form of self-expression that involves clothing, accessories, and personal style. It is a constantly evolving industry that is influenced by cultural and social trends, as well as historical and artistic movements. Fashion can be both functional and decorative, with clothing serving both practical and aesthetic purposes. Fashion designers create clothing and accessories that reflect their unique vision and style, with runway shows and fashion weeks showcasing their latest creations. The fashion industry also encompasses manufacturing, marketing, and retail, with clothing brands and retailers catering to a diverse range of consumer tastes and preferences. While fashion can be seen as a form of artistic expression, it can also have environmental and social impacts, with concerns about the use of natural resources and labor practices in the production of clothing. Nonetheless, fashion continues to play a significant role in contemporary culture, with individuals expressing their identity and creativity through their clothing and personal style.", 'fashion_2.jpg');
