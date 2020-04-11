CREATE TABLE `__prefix__Activity` (
    `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
    `active` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Y',
    `registration` varchar(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Y' COMMENT 'Can a parent/student select this for registration?',
    `name` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
    `provider` varchar(8) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'School',
    `activity_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `academic_year_term_list` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
    `listing_start` date DEFAULT NULL,
    `listing_end` date DEFAULT NULL,
    `program_start` date DEFAULT NULL,
    `program_end` date DEFAULT NULL,
    `description` longtext COLLATE utf8_unicode_ci,
    `payment` decimal(8,2) DEFAULT NULL,
    `payment_firmness` varchar(9) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'Finalised',
    `payment_type` varchar(24) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'Entire Programme',
    `year_group_list` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci COMMENT '(DC2Type:simple_array)',
    `max_participants` int(3) UNSIGNED DEFAULT NULL,
    `academic_year` int(3) UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`,`academic_year`) USING BTREE,
    KEY `AcademicYear` (`academic_year`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `__prefix__ActivityAttendance` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `attendance` longtext COLLATE utf8_unicode_ci NOT NULL,
    `date` date DEFAULT NULL,
    `timestamp_taken` datetime NOT NULL COMMENT '(DC2Type:date_immutable)',
    `activity` int(8) UNSIGNED DEFAULT NULL,
    `person_taker` int(10) UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `activity` (`activity`) USING BTREE,
    KEY `personTaker` (`person_taker`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `__prefix__ActivitySlot` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `location_external` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `time_start` time NOT NULL COMMENT '(DC2Type:time_immutable)',
    `time_end` time NOT NULL COMMENT '(DC2Type:time_immutable)',
    `activity` int(8) UNSIGNED DEFAULT NULL,
    `facility` int(10) UNSIGNED DEFAULT NULL,
    `day_of_week` int(2) UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `activity` (`activity`) USING BTREE,
    KEY `dayOfWeek` (`day_of_week`) USING BTREE,
    KEY `facility` (`facility`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE IF NOT EXISTS `__prefix__activitystaff` (
     `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
     `role` varchar(9) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Organiser',
     `activity` int(8) UNSIGNED DEFAULT NULL,
     `person` int(10) UNSIGNED DEFAULT NULL,
     PRIMARY KEY (`id`),
     KEY `activity` (`activity`) USING BTREE,
     KEY `person` (`person`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
CREATE TABLE `__prefix__ActivityStudent` (
    `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    `status` varchar(12) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Pending',
    `timestamp` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
    `invoice_generated` varchar(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N',
    `activity` int(8) UNSIGNED DEFAULT NULL,
    `person` int(10) UNSIGNED DEFAULT NULL,
    `activity_backup` int(8) UNSIGNED DEFAULT NULL,
    `invoice` int(14) UNSIGNED DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `activityPerson` (`person`,`activity`),
    KEY `activity` (`activity`) USING BTREE,
    KEY `invoice` (`invoice`) USING BTREE,
    KEY `backupActivity` (`activity_backup`) USING BTREE,
    KEY `person` (`person`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;