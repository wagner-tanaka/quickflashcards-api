CREATE PROCEDURE InsertCardPhrase(
    IN card_id_param BIGINT,
    IN phrase_param TEXT,
    IN created_at_param TIMESTAMP,
    IN updated_at_param TIMESTAMP
)
BEGIN
    DECLARE currentDate TIMESTAMP;
    SET currentDate = NOW();

INSERT INTO card_phrases (
    card_id,
    phrase,
    created_at,
    updated_at
) VALUES (
             card_id_param,
             phrase_param,
             IFNULL(created_at_param, currentDate),
             IFNULL(updated_at_param, currentDate)
         );
END
