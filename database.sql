SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE booking (
  booking_id int(11) NOT NULL,
  start_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  end_date datetime NOT NULL,
  extras_price int(11) NOT NULL DEFAULT '0',
  rooms_price int(11) NOT NULL DEFAULT '0',
  total_price int(11) NOT NULL DEFAULT '0',
  paid_date datetime NOT NULL,
  customer_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE booking_room (
  booking_room_id int(11) NOT NULL,
  booking_id int(11) NOT NULL,
  room_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE customer (
  customer_id int(11) NOT NULL,
  title varchar(10) NOT NULL,
  first_name tinytext NOT NULL,
  last_name tinytext NOT NULL,
  business_name tinytext NOT NULL,
  email_address tinytext NOT NULL,
  phone_number varchar(13) NOT NULL,
  address_line_1 tinytext NOT NULL,
  address_line_2 tinytext NOT NULL,
  town_city tinytext NOT NULL,
  post_code varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE room (
  room_id int(11) NOT NULL,
  room_number varchar(10) NOT NULL,
  wheelchair_access int(1) NOT NULL DEFAULT '0',
  room_type_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO room (room_id, room_number, wheelchair_access, room_type_id) VALUES
(1, '101', 1, 1),
(3, '102', 1, 1),
(4, '103', 1, 1),
(5, '104', 1, 2),
(6, '105', 1, 2),
(7, '106', 1, 3),
(8, '201', 0, 1),
(9, '202', 0, 1),
(10, '203', 0, 1),
(11, '204', 0, 2),
(12, '205', 0, 2),
(13, '206', 0, 3);

CREATE TABLE room_type (
  room_type_id int(11) NOT NULL,
  name tinytext NOT NULL,
  per_night_price int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO room_type (room_type_id, name, per_night_price) VALUES
(1, 'Single', 8500),
(2, 'Double', 13500),
(3, 'Suite', 22000);


ALTER TABLE booking
  ADD PRIMARY KEY (booking_id),
  ADD KEY fk_booking_customer (customer_id) USING BTREE;

ALTER TABLE booking_room
  ADD PRIMARY KEY (booking_room_id),
  ADD KEY fk_booking (booking_id) USING BTREE,
  ADD KEY fk_room (room_id);

ALTER TABLE customer
  ADD PRIMARY KEY (customer_id);

ALTER TABLE room
  ADD PRIMARY KEY (room_id),
  ADD KEY fk_room_type (room_type_id) USING BTREE;

ALTER TABLE room_type
  ADD PRIMARY KEY (room_type_id);


ALTER TABLE booking
  MODIFY booking_id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE booking_room
  MODIFY booking_room_id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE customer
  MODIFY customer_id int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE room
  MODIFY room_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE room_type
  MODIFY room_type_id int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE booking
  ADD CONSTRAINT booking_ibfk_1 FOREIGN KEY (customer_id) REFERENCES customer (customer_id);

ALTER TABLE booking_room
  ADD CONSTRAINT booking_room_ibfk_1 FOREIGN KEY (booking_id) REFERENCES booking (booking_id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT booking_room_ibfk_2 FOREIGN KEY (room_id) REFERENCES room (room_id);

ALTER TABLE room
  ADD CONSTRAINT room_ibfk_1 FOREIGN KEY (room_type_id) REFERENCES room_type (room_type_id) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;
