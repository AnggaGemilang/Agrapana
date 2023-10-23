void phtanah()  
{ 
  bacaSensorPH = analogRead(pinPH); //baca pH
 delay(500);
  nilaiPH = (-0.0139*bacaSensorPH)+7.7851; //rumus pembacaan sensor pH
  doc["monitoring"]["soil_ph"] = nilaiPH;
  lcd.setCursor(0,2);
  lcd.print("Ph Tanah    =");
  lcd.setCursor(13,2);
  lcd.print(nilaiPH);
  lcd.setCursor(19,2);
  delay(5000);
}
