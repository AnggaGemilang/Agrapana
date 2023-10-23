void kelembabantanah ()
{
  // Serial.print("Persentase Kelembaban Tanah = ");
  digitalWrite(powerPin, HIGH);

  float kelembabanTanah;
  int hasilPembacaan = analogRead(SoilSensor);
  kelembabanTanah = (100 - ((hasilPembacaan/4095.00)*100));
  doc["monitoring"]["soil_humidity"] = kelembabanTanah;
  // Serial.print(kelembabanTanah);
  // Serial.println("%");
  lcd.setCursor(0,0);
  lcd.print("Kelembaban T=");
  lcd.setCursor(13,0);
  lcd.print(kelembabanTanah);
  lcd.setCursor(20,0);
  lcd.print("%");
  delay (1000);
  digitalWrite(powerPin, LOW);
  delay (1000);

 
}
