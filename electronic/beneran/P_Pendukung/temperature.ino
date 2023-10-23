void Temperature() {
   float nilai_suhu;
   nilai_suhu=baca_suhu();
   doc["monitoring"]["soil_temperature"] = nilai_suhu;
   lcd.setCursor(0,1);
   lcd.print("Suhu Tanah  =");
   lcd.setCursor(13,1);
   lcd.print(nilai_suhu);
   lcd.setCursor(19,1);
   lcd.print("C");
   delay(1000);
}

float baca_suhu()
{

  sensorSuhu.requestTemperatures();
  float suhu = sensorSuhu.getTempCByIndex(0);

  return suhu; 
}
