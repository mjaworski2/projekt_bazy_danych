CREATE VIEW availableBooks AS
    SELECT * FROM ksiazka FULL JOIN zamowienie USING(id_ksiazka)
    WHERE COALESCE(data_zwrotu, '1970-01-01') < current_date;