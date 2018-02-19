CREATE VIEW Einkauf AS (
  SELECT Person.Name AS Name, Person.ID AS ID, kaufen.MA_FL_ID AS ProdID, kaufen.Anzahl as Anzahl
  FROM (kaufen INNER JOIN Person ON kaufen.P_ID = Person.ID)
  GROUP BY Person.Name, Person.ID, kaufen.Anzahl, kaufen.MA_FL_ID
  HAVING SUM(Anzahl)>3
);

