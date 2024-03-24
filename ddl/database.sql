DROP TABLE IF EXISTS UserCourse;
DROP TABLE IF EXISTS UserDept;
DROP TABLE IF EXISTS Comments;
DROP TABLE IF EXISTS Likes;
DROP TABLE IF EXISTS Posts;
DROP TABLE IF EXISTS Course;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Department;




-- Table for storing user information
CREATE TABLE Users (
    userID INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    userpassword VARCHAR(255) NOT NULL,
    profileimage LONGBLOB, -- this stores the image in our system
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    isAdmin BOOLEAN DEFAULT FALSE
);

-- Table for storing groups (e.g., majors and minors)
-- Think Computer Science, Data Science, Engineering etc.
CREATE TABLE Department (
    departmentID INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    shorthand CHAR(4) NOT NULL,
    description TEXT
);

-- Table for storing class sections within subgroups
-- Think COSC 101, COSC 111 etc.
CREATE TABLE Course (
    courseID INT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    departmentID INT,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (departmentID) REFERENCES Department(departmentID) ON DELETE CASCADE
);

-- Table for storing posts
CREATE TABLE Posts (
    postID INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(50) NOT NULL,
    content TEXT NOT NULL,
    userID INT,
    departmentID INT NOT NULL,
    courseID INT,
    postImage LONGBLOB, -- this stores the image in our system
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userID) REFERENCES Users(userID) ON DELETE CASCADE,
    FOREIGN KEY (courseID) REFERENCES Course(courseID) ON DELETE CASCADE,
    FOREIGN KEY (departmentID) REFERENCES Department(departmentID) ON DELETE CASCADE
);

-- Table for storing comments on posts
CREATE TABLE Comments (
    commentID INT PRIMARY KEY AUTO_INCREMENT,
    content TEXT NOT NULL,
    title TEXT NOT NULL,
    userID INT,
    postID INT,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userID) REFERENCES Users(userID) ON DELETE CASCADE,
    FOREIGN KEY (postID) REFERENCES Posts(postID) ON DELETE CASCADE
);

-- Table for mapping users to departments (many-to-many relationship)
CREATE TABLE UserDept (
    userID INT,
    departmentID INT,
    PRIMARY KEY (userID, departmentID),
    FOREIGN KEY (userID) REFERENCES Users(userID) ON DELETE CASCADE,
    FOREIGN KEY (departmentID) REFERENCES Department(departmentID) ON DELETE CASCADE
);

-- Table for mapping users to courses (many-to-many relationship)
CREATE TABLE UserCourse (
    userID INT,
    courseID INT,
    PRIMARY KEY (userID, courseID),
    FOREIGN KEY (userID) REFERENCES Users(userID) ON DELETE CASCADE,
    FOREIGN KEY (courseID) REFERENCES Course(courseID) ON DELETE CASCADE
);

-- Table for the likes a post has
CREATE TABLE Likes(
    userID INT,
    postID INT,
    PRIMARY KEY(userID, postID),
    FOREIGN KEY (userID) REFERENCES Users(userID),
    FOREIGN KEY (postID) REFERENCES Posts(postID)
);


INSERT INTO Users(username, firstname, lastname, email, userpassword, isAdmin) VALUES('imoudu','Imoudu', 'Ibrahim', 'imoudu@gmail.com', 'thegoat@13', TRUE);
INSERT INTO Users(username, firstname, lastname, email, userpassword, isAdmin) VALUES('gavin','Gavin', 'Ashworth',  'gavin@gmail.com', 'milkyway#14', TRUE);
INSERT INTO Users(username, firstname, lastname, email, userpassword, isAdmin) VALUES('hadi','Hadi', 'Razmi',  'hadi@gmail.com', 'bestphotographer22', TRUE);

-- These are some random values that were generated so that 
INSERT INTO Users (username, firstname, lastname, email, userpassword, profileimage)
VALUES 
    ('john_doe', 'John', 'Doe', 'john.doe@example.com', 'password123', NULL),
    ('jane_smith', 'Jane', 'Smith', 'jane.smith@example.com', 'securepass', NULL),
    ('alexander_wang', 'Alexander', 'Wang', 'alexander.wang@example.com', 'p@ssw0rd', NULL),
    ('sarah_jackson', 'Sarah', 'Jackson', 'sarah.jackson@example.com', '123456', NULL),
    ('michael_nguyen', 'Michael', 'Nguyen', 'michael.nguyen@example.com', 'password', NULL),
    ('emily_garcia', 'Emily', 'Garcia', 'emily.garcia@example.com', 'letmein', NULL);
    
INSERT INTO Users (username, firstname, lastname, email, userpassword, profileimage)
VALUES 
    ('ryan_smith', 'Ryan', 'Smith', 'ryan.smith@example.com', 'password123', NULL),
    ('amanda_johnson', 'Amanda', 'Johnson', 'amanda.johnson@example.com', 'securepass', NULL),
    ('daniel_miller', 'Daniel', 'Miller', 'daniel.miller@example.com', 'p@ssw0rd', NULL),
    ('olivia_brown', 'Olivia', 'Brown', 'olivia.brown@example.com', '123456', NULL),
    ('william_davis', 'William', 'Davis', 'william.davis@example.com', 'password', NULL),
    ('emily_rodriguez', 'Emily', 'Rodriguez', 'emily.rodriguez@example.com', 'letmein', NULL),
    ('ethan_martinez', 'Ethan', 'Martinez', 'ethan.martinez@example.com', 'qwerty', NULL),
    ('madison_hernandez', 'Madison', 'Hernandez', 'madison.hernandez@example.com', 'iloveyou', NULL),
    ('mason_lopez', 'Mason', 'Lopez', 'mason.lopez@example.com', 'abc123', NULL),
    ('ava_gonzalez', 'Ava', 'Gonzalez', 'ava.gonzalez@example.com', 'welcome', NULL),
    ('noah_wilson', 'Noah', 'Wilson', 'noah.wilson@example.com', '123abc', NULL),
    ('emma_anderson', 'Emma', 'Anderson', 'emma.anderson@example.com', 'password1', NULL),
    ('liam_taylor', 'Liam', 'Taylor', 'liam.taylor@example.com', 'pass1234', NULL),
    ('isabella_thomas', 'Isabella', 'Thomas', 'isabella.thomas@example.com', 'letmein123', NULL),
    ('james_white', 'James', 'White', 'james.white@example.com', 'ilovecoding', NULL),
    ('sophia_clark', 'Sophia', 'Clark', 'sophia.clark@example.com', 'hello123', NULL),
    ('logan_hall', 'Logan', 'Hall', 'logan.hall@example.com', '12345678', NULL),
    ('harper_james', 'Harper', 'James', 'harper.james@example.com', 'mypassword', NULL),
    ('benjamin_scott', 'Benjamin', 'Scott', 'benjamin.scott@example.com', 'password1234', NULL),
    ('grace_green', 'Grace', 'Green', 'grace.green@example.com', 'password12345', NULL);


INSERT INTO Department (name, shorthand, description) 
VALUES 
	('Computer Science', 'COSC', 'We make the computer compute things'),
	('Data Science', 'DATA', 'We analyze and provide meaningful information about large data sets'),
	('Mathematics', 'MATH', 'We compute things ourselves'),
	('Statistics', 'STAT', 'We figure out the probability of things happening'),
	('Biology', 'BIOL', 'Something about blood, cells, animals, etc.'),
	('Chemistry', 'CHEM', 'How much benzene can we add to this before it goes boom?'),
	('Physics', 'PHYS', 'I can find out Kinematics, Velocity, Vectors etc.'),
	('Managemnet', 'MGMT', 'We manage things'),
	('Health and Exercise Science', 'HES', 'IDK, something about being in good shape.'),
	('Nursing', 'NRSG', 'Can I take your blood?'),
	('Engineering', 'ENGR', 'We bring solutions to real world problems');
	
INSERT INTO UserDept (userID, departmentID) VALUES (1, 1);
INSERT INTO UserDept (userID, departmentID) VALUES (2, 2);
INSERT INTO UserDept (userID, departmentID) VALUES (3, 3);
INSERT INTO UserDept (userID, departmentID) VALUES (4, 4);
INSERT INTO UserDept (userID, departmentID) VALUES (5, 5);
INSERT INTO UserDept (userID, departmentID) VALUES (6, 6);
INSERT INTO UserDept (userID, departmentID) VALUES (7, 7);
INSERT INTO UserDept (userID, departmentID) VALUES (8, 8);
INSERT INTO UserDept (userID, departmentID) VALUES (9, 9);
INSERT INTO UserDept (userID, departmentID) VALUES (10, 10);
INSERT INTO UserDept (userID, departmentID) VALUES (11, 11);
INSERT INTO UserDept (userID, departmentID) VALUES (12, 1);
INSERT INTO UserDept (userID, departmentID) VALUES (13, 2);
INSERT INTO UserDept (userID, departmentID) VALUES (14, 3);
INSERT INTO UserDept (userID, departmentID) VALUES (15, 4);
INSERT INTO UserDept (userID, departmentID) VALUES (16, 5);
INSERT INTO UserDept (userID, departmentID) VALUES (17, 6);
INSERT INTO UserDept (userID, departmentID) VALUES (18, 7);
INSERT INTO UserDept (userID, departmentID) VALUES (19, 8);
INSERT INTO UserDept (userID, departmentID) VALUES (20, 9);
INSERT INTO UserDept (userID, departmentID) VALUES (21, 10);
INSERT INTO UserDept (userID, departmentID) VALUES (22, 11);
INSERT INTO UserDept (userID, departmentID) VALUES (23, 1);
INSERT INTO UserDept (userID, departmentID) VALUES (24, 2);
INSERT INTO UserDept (userID, departmentID) VALUES (25, 3);
INSERT INTO UserDept (userID, departmentID) VALUES (26, 4);

