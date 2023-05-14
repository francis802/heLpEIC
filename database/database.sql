

DROP TABLE IF EXISTS DEPARTMENT;
DROP TABLE IF EXISTS USER;
DROP TABLE IF EXISTS CLIENT;
DROP TABLE IF EXISTS AGENT;
DROP TABLE IF EXISTS ADMIN;
DROP TABLE IF EXISTS TICKET;
DROP TABLE IF EXISTS HASHTAG;
DROP TABLE IF EXISTS TICKET_HASHTAG;
DROP TABLE IF EXISTS FAQ;


CREATE TABLE DEPARTMENT (
    ID INTEGER PRIMARY KEY,
    DEP_NAME TEXT NOT NULL UNIQUE
);

CREATE TABLE USER (
    ID INTEGER PRIMARY KEY,
    USERNAME TEXT NOT NULL UNIQUE,
    PASSWORD TEXT NOT NULL,
    EMAIL TEXT NOT NULL,
    NAME TEXT NOT NULL
);

CREATE TABLE CLIENT (
    USER_ID INTEGER PRIMARY KEY,
    FOREIGN KEY (USER_ID) REFERENCES USER(ID)
);

CREATE TABLE AGENT (
    USER_ID INTEGER PRIMARY KEY,
    DEPARTMENT_ID INTEGER NOT NULL,
    FOREIGN KEY (USER_ID) REFERENCES USER(ID),
    FOREIGN KEY (DEPARTMENT_ID) REFERENCES DEPARTMENT(ID)
);

CREATE TABLE ADMIN (
    USER_ID INTEGER PRIMARY KEY,
    FOREIGN KEY (USER_ID) REFERENCES USER(ID)
);

CREATE TABLE TICKET (
    ID INTEGER PRIMARY KEY,
    CLIENT_ID INTEGER NOT NULL,
    AGENT_ID INTEGER NOT NULL,
    DEPARTMENT_ID INTEGER NOT NULL,
    TITLE TEXT NOT NULL,
    DESCRIPTION TEXT NOT NULL,
    STATUS TEXT NOT NULL,
    FOREIGN KEY (CLIENT_ID) REFERENCES CLIENT(USER_ID),
    FOREIGN KEY (AGENT_ID) REFERENCES AGENT(USER_ID),
    FOREIGN KEY (DEPARTMENT_ID) REFERENCES DEPARTMENT(ID)
);

CREATE TABLE HASHTAG (
    ID INTEGER PRIMARY KEY,
    TAG TEXT
);

CREATE TABLE TICKET_HASHTAG (
    TICKET_ID INTEGER NOT NULL,
    TAG INTEGER NOT NULL,
    FOREIGN KEY (TICKET_ID) REFERENCES TICKET(ID),
    FOREIGN KEY (TAG) REFERENCES HASHTAG(ID)
);

CREATE TABLE FAQ (
    ID INTEGER PRIMARY KEY,
    QUESTION TEXT NOT NULL,
    ANSWER TEXT NOT NULL,
    DEPARTMENT_ID INTEGER NOT NULL,
    CREATED_AT TEXT,
    UPDATED_AT TEXT,
    FOREIGN KEY (DEPARTMENT_ID) REFERENCES DEPARTMENT(ID)
);

INSERT INTO DEPARTMENT(ID, DEP_NAME) VALUES
  (1, 'Sales'),
  (2, 'Marketing'),
  (3, 'Finance'),
  (4, 'Human Resources'),
  (5, 'Engineering'),
  (6, 'Product Management'),
  (7, 'Customer Service'),
  (8, 'Operations'),
  (9, 'IT'),
  (10, 'Legal');

INSERT INTO USER(ID, USERNAME, [PASSWORD], EMAIL, [NAME]) VALUES
  (1, 'johnsmith', 'password123', 'johnsmith@example.com', 'John Smith'),
  (2, 'janedoe', 'password456', 'janedoe@example.com', 'Jane Doe'),
  (3, 'bobdoe', 'password789', 'bobdoe@example.com', 'Bob Doe'),
  (4, 'sarahjones', 'passwordabc', 'sarahjones@example.com', 'Sarah Jones'),
  (5, 'davidsmith', 'passworddef', 'davidsmith@example.com', 'David Smith'),
  (6, 'amandajones', 'passwordghi', 'amandajones@example.com', 'Amanda Jones'),
  (7, 'peterlee', 'passwordjkl', 'peterlee@example.com', 'Peter Lee'),
  (8, 'lisajohnson', 'passwordmno', 'lisajohnson@example.com', 'Lisa Johnson'),
  (9, 'michaelbrown', 'passwordpqr', 'michaelbrown@example.com', 'Michael Brown'),
  (10, 'karenwilson', 'passwordstu', 'karenwilson@example.com', 'Karen Wilson');

  INSERT INTO CLIENT(USER_ID) VALUES
  (1),
  (2),
  (3),
  (4),
  (5),
  (6),
  (7),
  (8),
  (9),
  (10);

  INSERT INTO AGENT(USER_ID, DEPARTMENT_ID) VALUES
  (1,1),
  (2,2),
  (3,3);

  INSERT INTO ADMIN(USER_ID) VALUES
  (1);