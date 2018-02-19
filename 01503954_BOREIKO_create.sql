CREATE TABLE Person (
  ID INTEGER CONSTRAINT per_pk PRIMARY KEY,
  Name VARCHAR(40) CONSTRAINT per_n_nn NOT NULL,
  Adresse VARCHAR(40) CONSTRAINT ad_n_nn NOT NULL, 
  Bankdaten VARCHAR(40) CONSTRAINT Bankdaten_n_nn NOT NULL
);

CREATE TABLE folgen (
  ID1 INTEGER CONSTRAINT folg_id1_nn NOT NULL,
  ID2 INTEGER CONSTRAINT folg_id2_nn NOT NULL,
  CONSTRAINT folg_neq_check CHECK (ID1 != ID2),
  CONSTRAINT folg_fk1 FOREIGN KEY (ID1) REFERENCES Person(ID) ON DELETE CASCADE,
  CONSTRAINT folg_fk2 FOREIGN KEY (ID2) REFERENCES Person(ID) ON DELETE CASCADE,
  CONSTRAINT folg_pk PRIMARY KEY (ID1, ID2)
);

CREATE TABLE Themen (
  ID INTEGER CONSTRAINT th_pk PRIMARY KEY,
  Name VARCHAR(40) CONSTRAINT th_n_nn NOT NULL
);

CREATE TABLE Fakten (
  ID INTEGER CONSTRAINT fk_pkk NOT NULL,
  Fakt VARCHAR(1000) CONSTRAINT fk_f_nn NOT NULL,
  T_ID INTEGER CONSTRAINT fk_th_nn NOT NULL,
  CONSTRAINT fk_fk FOREIGN KEY (T_ID) REFERENCES Themen(ID) ON DELETE CASCADE,
  CONSTRAINT fk_pk PRIMARY KEY (ID,T_ID)
);

CREATE TABLE sich_interessieren (
  P_ID INTEGER CONSTRAINT s_i_id1_nn NOT NULL,
  Struktur VARCHAR(40) CONSTRAINT s_i_str_nn NOT NULL,
  T_ID INTEGER CONSTRAINT s_i_id2_nn NOT NULL,
  CONSTRAINT s_i_fk1 FOREIGN KEY (P_ID) REFERENCES Person(ID) ON DELETE CASCADE,
  CONSTRAINT s_i_fk2 FOREIGN KEY (T_ID) REFERENCES Themen(ID) ON DELETE CASCADE,
  CONSTRAINT s_i_pk PRIMARY KEY (P_ID, T_ID)
);

CREATE TABLE Figuren_Leute (
  T_ID INTEGER CONSTRAINT f_l_fk_nn NOT NULL,
  Name VARCHAR(40) CONSTRAINT f_l_name_nn NOT NULL,
  Wichtigkeit FLOAT CONSTRAINT f_l_w_nn NOT NULL,
  Einflussbereich VARCHAR(40),
  CONSTRAINT f_l_fk FOREIGN KEY (T_ID) REFERENCES Themen(ID) ON DELETE CASCADE,
  CONSTRAINT f_l_pk PRIMARY KEY (T_ID)
);

CREATE TABLE Medien_Arhiv_Figuren_Leute (
  ID INTEGER CONSTRAINT ma_f_l_pk NOT NULL,
  Medien_pfad VARCHAR(40) CONSTRAINT ma_f_l_pfad_nn NOT NULL,
  Preis FLOAT,
  Name VARCHAR(40) CONSTRAINT ma_f_l_name_nn NOT NULL,
  FL_ID INTEGER CONSTRAINT ma_f_l_fk_nn NOT NULL,
  CONSTRAINT ma_f_l_fk FOREIGN KEY (FL_ID) REFERENCES Figuren_Leute(T_ID) ON DELETE CASCADE,
  CONSTRAINT m_a_f_l_pk PRIMARY KEY (ID, FL_ID)
);

CREATE TABLE Ereignisse (
  T_ID INTEGER CONSTRAINT er_fk_nn NOT NULL,
  Name VARCHAR(40) CONSTRAINT er_name_nn NOT NULL,
  Ort VARCHAR(40) CONSTRAINT er_ort_nn NOT NULL,
  Wichtigkeit FLOAT CONSTRAINT er_w_nn NOT NULL,
  CONSTRAINT er_fk FOREIGN KEY (T_ID) REFERENCES Themen(ID) ON DELETE CASCADE,
  CONSTRAINT er_pk PRIMARY KEY (T_ID)
);

CREATE TABLE Medien_Arhiv_Ereignise (
  ID INTEGER CONSTRAINT ma_er_nn NOT NULL,
  Medien_pfad VARCHAR(40) CONSTRAINT ma_er_pfad_nn NOT NULL,
  E_ID INTEGER CONSTRAINT ma_er_fk_nn NOT NULL,
  CONSTRAINT ma_er_fk FOREIGN KEY (E_ID) REFERENCES Ereignisse(T_ID) ON DELETE CASCADE,
  CONSTRAINT m_a_pk PRIMARY KEY (ID, E_ID)
);

CREATE TABLE kaufen(
  MA_FL_ID INTEGER CONSTRAINT ka_ma_fl_id_nn NOT NULL,
  MA_FL_FL_ID INTEGER CONSTRAINT ka_ma_fl_fl_id_nn NOT NULL,
  P_ID INTEGER CONSTRAINT ka_p_id_nn NOT NULL,
  Anzahl INTEGER CONSTRAINT ka_an_nn NOT NULL,
  CONSTRAINT ka_fk2 FOREIGN KEY (MA_FL_ID, MA_FL_FL_ID) REFERENCES Medien_Arhiv_Figuren_Leute(ID, FL_ID) ON DELETE CASCADE,
  CONSTRAINT ka_fk3 FOREIGN KEY (P_ID) REFERENCES Person(ID) ON DELETE CASCADE,
  CONSTRAINT ka_pk PRIMARY KEY (P_ID, MA_FL_ID,MA_FL_FL_ID),
  CONSTRAINT ka_an_ch CHECK (Anzahl > 0)
);

DROP SEQUENCE personid_seq_2;
DROP SEQUENCE themen_id_seq_1;
DROP SEQUENCE arhiv_f_l_id_seq_1;
CREATE SEQUENCE personid_seq_2 START WITH 1;
CREATE SEQUENCE themen_id_seq_1 START WITH 1;
CREATE SEQUENCE arhiv_f_l_id_seq_1 START WITH 1;


CREATE OR REPLACE TRIGGER personid_t
BEFORE INSERT ON Person
FOR EACH ROW

BEGIN
  SELECT personid_seq_2.NEXTVAL
  INTO   :new.ID
  FROM   dual;
END;

/

CREATE OR REPLACE TRIGGER themen_id_t
BEFORE INSERT ON Themen
FOR EACH ROW

BEGIN
  SELECT themen_id_seq_1.NEXTVAL
  INTO   :new.ID
  FROM   dual;
END;

/

CREATE OR REPLACE TRIGGER arhiv_fl_id_t
BEFORE INSERT ON Medien_Arhiv_Figuren_Leute
FOR EACH ROW

BEGIN
  SELECT arhiv_f_l_id_seq_1.NEXTVAL
  INTO   :new.ID
  FROM   dual;
END;

/
