void sensorhujan() {
  digitalWrite(Powerpin, HIGH);
  delay (2000);
  int rainDigitalVal = analogRead(rainDigital);
  doc["monitoring"]["rainfall"] = rainDigitalVal;
  if (rainDigitalVal <= 1024)
  {
    keadaan = "Tidak Hujan";
  }
  else if (rainDigitalVal <= 4010)
  {
    keadaan = "Sedang Hujan";
  }
  delay(1000);
  lcd.setCursor(0, 1);
  lcd.print("Keadaan=");
  lcd.setCursor(7, 1);
  lcd.print(keadaan);

  digitalWrite(Powerpin, LOW);
}
