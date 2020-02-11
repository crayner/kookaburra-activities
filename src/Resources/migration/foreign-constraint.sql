ALTER TABLE `__prefix__Activity`
    ADD CONSTRAINT FOREIGN KEY (`academic_year`) REFERENCES `__prefix__AcademicYear` (`id`);

ALTER TABLE `__prefix__ActivityAttendance`
    ADD CONSTRAINT FOREIGN KEY (`activity`) REFERENCES `__prefix__Activity` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`person_taker`) REFERENCES `__prefix__Person` (`id`);

ALTER TABLE `__prefix__activityslot`
    ADD CONSTRAINT FOREIGN KEY (`activity`) REFERENCES `__prefix__Activity` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`facility`) REFERENCES `__prefix__Facility` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`day_of_week`) REFERENCES `__prefix__DaysOfWeek` (`id`);

ALTER TABLE `__prefix__ActivityStaff`
    ADD CONSTRAINT FOREIGN KEY (`activity`) REFERENCES `__prefix__Activity` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`person`) REFERENCES `__prefix__Person` (`id`);

ALTER TABLE `__prefix__ActivityStudent`
    ADD CONSTRAINT FOREIGN KEY (`activity`) REFERENCES `__prefix__Activity` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`person`) REFERENCES `__prefix__Person` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`activity_backup`) REFERENCES `__prefix__Activity` (`id`),
    ADD CONSTRAINT FOREIGN KEY (`invoice`) REFERENCES `__prefix__FinanceInvoice` (`__prefix__FinanceInvoiceID`);