ALTER TABLE Person ADD CONSTRAINT be_unique UNIQUE(Adresse);
ALTER TABLE Person ADD CONSTRAINT be_unique_bankdaten UNIQUE(Bankdaten);
ALTER TABLE Medien_Arhiv_Figuren_Leute ADD CONSTRAINT preis_g_zero CHECK (Preis > 0);
