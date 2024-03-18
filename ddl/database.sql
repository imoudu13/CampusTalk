DROP TABLE IF EXISTS Comments;
DROP TABLE IF EXISTS Posts;
DROP TABLE IF EXISTS ClassSections;
DROP TABLE IF EXISTS UserGroup;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Groups;




-- Table for storing user information
CREATE TABLE Users (
    userID INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    userpassword VARCHAR(255) NOT NULL,
    profileimage BLOB, -- this stores the image in our system
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    isAdmin BOOLEAN DEFAULT FALSE
);

-- Table for storing groups (e.g., majors and minors)
CREATE TABLE `Groups` (
    groupID INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for mapping users to subgroups (many-to-many relationship)
CREATE TABLE UserGroup (
    userID INT,
    groupID INT,
    PRIMARY KEY (userID, groupID),
    FOREIGN KEY (userID) REFERENCES Users(userID) ON DELETE CASCADE,
    FOREIGN KEY (groupID) REFERENCES `Groups`(groupID) ON DELETE CASCADE
);

-- Table for storing class sections within subgroups
CREATE TABLE ClassSections (
    sectionID INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    groupID INT,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (groupID) REFERENCES `Groups`(groupID) ON DELETE CASCADE
);

-- Table for storing posts
CREATE TABLE Posts (
    postID INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    userID INT,
    sectionID INT,
    postImage BLOB, -- this stores the image in our system
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userID) REFERENCES Users(userID) ON DELETE CASCADE,
    FOREIGN KEY (sectionID) REFERENCES ClassSections(sectionID) ON DELETE CASCADE
);

-- Table for storing comments on posts
CREATE TABLE Comments (
    commentID INT PRIMARY KEY AUTO_INCREMENT,
    content TEXT NOT NULL,
    userID INT,
    postID INT,
    createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userID) REFERENCES Users(userID) ON DELETE CASCADE,
    FOREIGN KEY (postID) REFERENCES Posts(postID) ON DELETE CASCADE
);

INSERT INTO Users(username, firstname, lastname, email, userpassword, isAdmin) VALUES('imoudu','Imoudu', 'Ibrahim', 'imoudu@gmail.com', 'thegoat@13', TRUE);
INSERT INTO Users(username, firstname, lastname, email, userpassword, isAdmin) VALUES('gavin','Gavin', 'Ashworth',  'gavin@gmail.com', 'milkyway#14', TRUE);
INSERT INTO Users(username, firstname, lastname, email, userpassword, isAdmin) VALUES('hadi','Hadi', 'Razmi',  'hadi@gmail.com', 'bestphotographer22', TRUE);
