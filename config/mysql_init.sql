DROP DATABASE dbstuff;
CREATE DATABASE dbstuff;
CREATE user 'dbstuff'@'localhost' IDENTIFIED BY 'dbstuff';
GRANT ALL PRIVILEGES ON dbstuff.* TO 'dbstuff'@'localhost';
