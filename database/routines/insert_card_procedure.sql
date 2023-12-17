CREATE PROCEDURE InsertCard(
    IN deck_id_param BIGINT,
    IN front_param TEXT,
    IN back_param TEXT,
    IN pronunciation_param TEXT,
    IN review_level_param INT,
    IN last_reviewed_date_param DATE,
    IN next_review_date_param DATE
)
BEGIN
    DECLARE currentDate DATE;
    SET currentDate = CURDATE();

INSERT INTO cards (
    deck_id,
    front,
    back,
    pronunciation,
    review_level,
    last_reviewed_date,
    next_review_date,
    created_at,
    updated_at
) VALUES (
             deck_id_param,
             front_param,
             back_param,
             IFNULL(pronunciation_param, ''),
             review_level_param,
             IFNULL(last_reviewed_date_param, currentDate),
             IFNULL(next_review_date_param, currentDate),
             currentDate,
             currentDate
         );
END
