import java.sql.*;
import oracle.jdbc.driver.*;
import java.util.*;
import java.util.concurrent.ThreadLocalRandom;

public class TestDataGenerator {
	public static void main(String args[]) {

	    try {
	      Class.forName("oracle.jdbc.driver.OracleDriver");
	      String database = "jdbc:oracle:thin:@oracle-lab.cs.univie.ac.at:1521:lab";
	      String user = "a01503954";
	      String pass = "dbs17";

	      // establish connection to database 
	      Connection con = DriverManager.getConnection(database, user, pass);
	      Statement stmt = con.createStatement();


	      //Person
	      
	      ResultSet rs1 = stmt.executeQuery("Delete FROM Person");
	      rs1.close();
	      int num = 2000;
	      for (int i = 1; i <= num; i++) {
	    	  try {
	    		  
	    		  String randomNum = String.valueOf(ThreadLocalRandom.current().nextInt(100000, 1000000));
	    		  String s= String.valueOf(i);
		    	  String insertSql = "INSERT INTO Person (Name, Adresse, Bankdaten) VALUES ('Name"+s+"', 'name"+s+".adresse','" + randomNum + "')";
		    	  stmt.executeUpdate(insertSql);
		    	} catch (Exception e) {
		    	  System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
		    	}
	      }

          ResultSet rd1 = stmt.executeQuery("SELECT COUNT(*) FROM Person");
          
          if (rd1.next()) {
              int count1 = rd1.getInt(1);
              System.out.println("Number of datasets of Person: " + count1);
          }
          
          //folgen
          
          ResultSet rs1_1 = stmt.executeQuery("Delete FROM folgen");
	      rs1_1.close();
	      
	      for (int i = 1; i <= num; i++) {
	    	  try {
	    		  String s1 = String.valueOf(i);
	    		  String s2 = String.valueOf(i%5+1);
		    	  String insertSql = "INSERT INTO folgen VALUES ('"+s1+"','"+s2+"')";
		    	  stmt.executeUpdate(insertSql);
		    	} catch (Exception e) {
		    	  System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
		    	}
	      }
	      
	      ResultSet rd1_1 = stmt.executeQuery("SELECT COUNT(*) FROM folgen");
          
          if (rd1_1.next()) {
              int count1_1 = rd1_1.getInt(1);
              System.out.println("Number of datasets of folgen: " + count1_1);
          }
          
          //Themen
	      
	      ResultSet rs2 = stmt.executeQuery("Delete FROM Themen");
	      rs2.close();
	      
	      for (int i = 1; i <= 2*num; i++) {
	    	  try {
	    		  String s = String.valueOf(i);
		    	  String insertSql = "INSERT INTO Themen VALUES ('"+s+"','Name"+s+"')";
		    	  stmt.executeUpdate(insertSql);
		    	} catch (Exception e) {
		    	  System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
		    	}
	      }
	      
	      ResultSet rd2 = stmt.executeQuery("SELECT COUNT(*) FROM Themen");
          
          if (rd2.next()) {
              int count2 = rd2.getInt(1);
              System.out.println("Number of datasets of Themen: " + count2);
          }
          
          //Fakten
          
          ResultSet rs3 = stmt.executeQuery("Delete FROM Fakten");
	      rs3.close();
	      
	      for (int i = 1; i <= num; i++) {
	    	  try {
	    		  String s1 = String.valueOf(i);
	    		  String s2 = String.valueOf(i%5+1);
		    	  String insertSql = "INSERT INTO Fakten VALUES ('"+s1+"','Fakt"+s1+"','"+s2+"')";
		    	  stmt.executeUpdate(insertSql);
		    	} catch (Exception e) {
		    	  System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
		    	}
	      }
	      
	      ResultSet rd3 = stmt.executeQuery("SELECT COUNT(*) FROM Fakten");
          
          if (rd3.next()) {
              int count3 = rd3.getInt(1);
              System.out.println("Number of datasets of Fakten: " + count3);
          }
          
          //sich_interessieren
          
          ResultSet rs4 = stmt.executeQuery("Delete FROM sich_interessieren");
	      rs4.close();
	      
	      for (int i = 1; i <= num; i++) {
	    	  try {
	    		  String s1 = String.valueOf(i);
	    		  String s2 = String.valueOf(i%5+1);
		    	  String insertSql = "INSERT INTO sich_interessieren VALUES ('"+s1+"','Struktur"+s1+"','"+s2+"')";
		    	  stmt.executeUpdate(insertSql);
		    	} catch (Exception e) {
		    	  System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
		    	}
	      }
	      
	      ResultSet rd4 = stmt.executeQuery("SELECT COUNT(*) FROM sich_interessieren");
          
          if (rd4.next()) {
              int count4 = rd4.getInt(1);
              System.out.println("Number of datasets of sich_interessieren: " + count4);
          }
          
          //Figuren_Leute
          
          ResultSet rs5 = stmt.executeQuery("Delete FROM Figuren_Leute");
	      rs5.close();
	      
	      for (int i = 1; i <= num; i++) {
	    	  try {
	    		  Random r = new Random();
	    		  String gaus_ran = String.valueOf(r.nextGaussian());
	    		  String s1 = String.valueOf(i);
		    	  String insertSql = "INSERT INTO Figuren_Leute VALUES ('"+s1+"','Name"+s1+"','"+gaus_ran+"','Einflussbereich"+s1+"')";
		    	  stmt.executeUpdate(insertSql);
		    	} catch (Exception e) {
		    	  System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
		    	}
	      }
	      
	      ResultSet rd5 = stmt.executeQuery("SELECT COUNT(*) FROM Figuren_Leute");
          
          if (rd5.next()) {
              int count5 = rd5.getInt(1);
              System.out.println("Number of datasets of Figuren_Leute: " + count5);
          }
          
          //Medien_Arhiv_Figuren_Leute
          
          ResultSet rs6 = stmt.executeQuery("Delete FROM Medien_Arhiv_Figuren_Leute");
	      rs6.close();
	      
	      for (int i = 1; i <= num; i++) {
	    	  try {
	    		  String s1 = String.valueOf(i);
	    		  String s2 = String.valueOf(i%5+1);
	    		  String preis = String.valueOf(ThreadLocalRandom.current().nextInt(1000, 10000));
		    	  String insertSql = "INSERT INTO Medien_Arhiv_Figuren_Leute VALUES ('"+s1+"','url"+s1+"','"+preis+"','media_fl_"+s1+"','"+s2+"')";
		    	  stmt.executeUpdate(insertSql);
		    	} catch (Exception e) {
		    	  System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
		    	}
	      }
	      
	      ResultSet rd6 = stmt.executeQuery("SELECT COUNT(*) FROM Medien_Arhiv_Figuren_Leute");
          
          if (rd6.next()) {
              int count6 = rd6.getInt(1);
              System.out.println("Number of datasets of Medien_Arhiv_Figuren_Leute: " + count6);
          }
          
          //Ereignisse
          
          ResultSet rs7 = stmt.executeQuery("Delete FROM Ereignisse");
	      rs7.close();
	      
	      for (int i = num+1; i <= 2*num; i++) {
	    	  try {
	    		  Random r = new Random();
	    		  String gaus_ran = String.valueOf(r.nextGaussian());
	    		  String s1 = String.valueOf(i);
		    	  String insertSql = "INSERT INTO Ereignisse VALUES ('"+s1+"','Name"+s1+"','Ort"+s1+"','"+gaus_ran+"')";
		    	  stmt.executeUpdate(insertSql);
		    	} catch (Exception e) {
		    	  System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
		    	}
	      }
	      
	      ResultSet rd7 = stmt.executeQuery("SELECT COUNT(*) FROM Ereignisse");
          
          if (rd7.next()) {
              int count7 = rd7.getInt(1);
              System.out.println("Number of datasets of Ereignisse: " + count7);
          }
          
          //Medien_Arhiv_Ereignise
          
          ResultSet rs8 = stmt.executeQuery("Delete FROM Medien_Arhiv_Ereignise");
	      rs8.close();
	      
	      for (int i = 1; i <= num; i++) {
	    	  try {
	    		  String s1 = String.valueOf(i);
	    		  String s2 = String.valueOf(i%5+num+1);
		    	  String insertSql = "INSERT INTO Medien_Arhiv_Ereignise VALUES ('"+s1+"','url"+s1+"','"+s2+"')";
		    	  stmt.executeUpdate(insertSql);
		    	} catch (Exception e) {
		    	  System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
		    	}
	      }
	      
	      ResultSet rd8 = stmt.executeQuery("SELECT COUNT(*) FROM Medien_Arhiv_Ereignise");
          
          if (rd8.next()) {
              int count8 = rd8.getInt(1);
              System.out.println("Number of datasets of Medien_Arhiv_Ereignise: " + count8);
          }
          
          //kaufen
          
          ResultSet rs9 = stmt.executeQuery("Delete FROM kaufen");
	      rs9.close();
	      
	      for (int i = 1; i <= num; i++) {
	    	  try {
	    		  String s1 = String.valueOf(i);
	    		  String s2 = String.valueOf(i%5+1);
	    		  String s3 = String.valueOf(i%8+1);
	    		  String anzahl = String.valueOf(ThreadLocalRandom.current().nextInt(1, 10));
		    	  String insertSql = "INSERT INTO kaufen VALUES ('"+s1+"','"+s2+"','"+s3+"','"+anzahl+"')";
		    	  stmt.executeUpdate(insertSql);
		    	} catch (Exception e) {
		    	  System.err.println("Fehler beim Einfuegen des Datensatzes: " + e.getMessage());
		    	}
	      }
	      
	      ResultSet rd9 = stmt.executeQuery("SELECT COUNT(*) FROM kaufen");
          
          if (rd9.next()) {
              int count9 = rd9.getInt(1);
              System.out.println("Number of datasets of kaufen: " + count9);
          }
          
 	      stmt.close();
	      con.close();

	    }catch (Exception e) {
	      System.out.println("Error");
	      System.err.println(e.getMessage());
	    }
	  
	  }
}
