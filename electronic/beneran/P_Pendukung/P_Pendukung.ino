#include <SPI.h>
#include <LoRa.h>
#define ss 5
#define rst 14
#define dio0 16
#include <SoftwareSerial.h>
#include <Wire.h>


#include <LiquidCrystal_I2C.h>


#include <OneWire.h>

#include <DallasTemperature.h>

#define ONE_WIRE_BUS 27

OneWire oneWire(ONE_WIRE_BUS);

DallasTemperature sensorSuhu(&oneWire);

SoftwareSerial NPK(3, 1); // RX, TX
LiquidCrystal_I2C lcd(0x27,20,4);
int powerPin = 13;    // untuk pengganti VCC
const int SoilSensor = 26;
int counter = 0;

//NPK

//temperature

// Ph tanah
#define pinPH 25  //pin output Sensor PH ditempatkan di D3 //sambungkan kabel hitam (output) ke pin 25
int bacaSensorPH = 0;   //membaca hasil dari sensor pH   
float nilaiPH = 0.0; //nilai pH yang ditampilkan

void kelembabantanah ();
void Temperature();
void phtanah() ;

StaticJsonDocument<200> doc;
char output[200];

void setup() {
  Serial.begin(9600);
  while (!Serial);
  
  LoRa.setPins(ss, rst, dio0); 
  Serial.println("LoRa Sender");

  if (!LoRa.begin(433E6)) {
    Serial.println("Starting LoRa failed!");
    while (1);
  }

  NPK.begin(9600);
  
  // Kelembaban tanah
  // jadikan pin power sebagai output
  pinMode(powerPin, OUTPUT);
  // default bernilai LOW
  digitalWrite(powerPin, LOW);
  // mulai komunikasi serial
  
  //ph
  pinMode(pinPH,INPUT);  //inisialisasi pinPH sebagai input

  //lcd
  lcd.init();                      // initialize the lcd 
  // Print a message to the LCD.
  lcd.backlight();


}

void loop() {
  Serial.print("Sending packet: ");
  Serial.println(counter);
  counter++;
  // send packet
  LoRa.beginPacket();
  LoRa.println("Node2");
  LoRa.println(counter);
  doc["source"] = "pendukung";
  kelembabantanah();
  Temperature();
  phtanah();
  serializeJson(doc, output);
  LoRa.print(output);
  LoRa.endPacket();
  // lcd.clear();
  Serial.println("  ");
  delay(5000);
  doc.clear();
}
