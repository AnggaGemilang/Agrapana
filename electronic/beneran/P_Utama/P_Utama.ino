#include <Wire.h>
#include "RTClib.h"
#include <PubSubClient.h>
#include <ArduinoJson.h>
#include <SPI.h>
#include <LoRa.h>
#include <BH1750.h>
// #include <WiFi.h>
#include <Adafruit_BME280.h> 
#include <Adafruit_Sensor.h> 

// #define MSG_BUFFER_SIZE (50)
#define rainDigital 26 
int Powerpin =27;
// #define WIFI_SSID "Samsung Galaxy M33"
// #define WIFI_PASSWORD "anggaganteng"
// #define MQTT_SERVER "test.mosquitto.org"
#define ss 5
#define rst 14
#define dio0 16
#include <LiquidCrystal_I2C.h>
#define SEALEVELPRESSURE_HPA (1013.25) //nilai awal untuk pressure

RTC_DS3231 rtc;
BH1750 lightMeter;
Adafruit_BME280 bme; //penggunaan I2C
String keadaan;

unsigned long lastMsg = 0;
// char msg[MSG_BUFFER_SIZE];
char daysOfTheWeek[7][12] = {"Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu"};
int counter = 0;

// WiFiClient espClient;
// PubSubClient client(espClient);

// anemometer parameters
volatile byte rpmcount; // count signals
volatile unsigned long last_micros;
unsigned long timeold;
unsigned long timemeasure = 25.00; // seconds
int timetoSleep = 1;               // minutes
unsigned long sleepTime = 15;      // minutes
unsigned long timeNow;
int countThing = 0;
int GPIO_pulse = 25; // ESP32 = D14
float rpm, rps;     // frequencies
float radius = 0.1; // meters - measure of the lenght of each the anemometer wing
float velocity_kmh; // km/h
float velocity_ms;  //m/s
float omega = 0;    // rad/s
float calibration_value = 2.0;
volatile boolean flag = false;
void ICACHE_RAM_ATTR rpm_anemometer()
{
  flag = true;
}


// LCD
LiquidCrystal_I2C lcd(0x27,20,4);

void BME();
void LCD();
void Sensorwaktu();
void bh1750();
void sensorhujan();
void anemometer();

StaticJsonDocument<150> doc;
char output[200];

void setup() {
  Serial.begin(9600);

  //LoRa
  while (!Serial);
  Serial.println("LoRa Sender");
  LoRa.setPins(ss, rst, dio0);
  if (!LoRa.begin(433E6)) {
    Serial.println("Starting LoRa failed!");
    while (1);
  }
  Serial.println("LoRa Initializing OK!");
  

      // // RTC
      // if (! rtc.begin()) {
      // //Serial.println("RTC tidak terbaca");
      // while (1);
      // }
      // if (rtc.lostPower()) {
      //  //atur waktu sesuai waktu pada komputer
      //  rtc.adjust(DateTime(F(__DATE__), F(__TIME__)));
      //  //atur waktu secara manual
      //  // January 21, 2019 jam 10:30:00
      //  // rtc.adjust(DateTime(2019, 1, 25, 10, 30, 0));
      //  }
  

  // BH1750
  Wire.begin();
  
  // On esp8266 you can select SCL and SDA pins using Wire.begin(D4, D3);
  // For Wemos / Lolin D1 Mini Pro and the Ambient Light shield use
  // Wire.begin(D2, D1);
  lightMeter.begin();
  Serial.println(F("BH1750 Test begin"));

          // Sensor hujan
         pinMode(rainDigital,INPUT);
         pinMode(Powerpin, OUTPUT);
         digitalWrite(Powerpin, LOW);

  // BME280
  if (!bme.begin(0x76)) {
    Serial.println("tidak ada sensor BME280, Coba cek rangkaianmu!");
    while (1);
  }

  //Anemometer
  pinMode(GPIO_pulse, INPUT_PULLUP);
  digitalWrite(GPIO_pulse, LOW);
  
  detachInterrupt(digitalPinToInterrupt(GPIO_pulse));                         // force to initiate Interrupt on zero
  attachInterrupt(digitalPinToInterrupt(GPIO_pulse), rpm_anemometer, RISING); //Initialize the intterrupt pin
  rpmcount = 0;
  rpm = 0;
  timeold = 0;
  timeNow = 0;
  
  //LCD
  lcd.init();                      // initialize the lcd 
  // Print a message to the LCD.
  lcd.backlight();


}

void loop() {
  Serial.print("Sending packet: ");
  Serial.println(counter);
  // send packet 
  LoRa.beginPacket();
  counter++;
  LoRa.println("Node1");
  LoRa.println(counter);
  doc["source"] = "utama";
  // Sensorwaktu ();
  bh1750 ();
  sensorhujan ();
  anemometer();
  delay(3000);
  lcd.clear();
  BME ();
  serializeJson(doc, output);
  LoRa.println(output);
  LoRa.endPacket();
  delay(3000);
  lcd.clear();
  Serial.println("  ");
  delay(2000);
  doc.clear();
}
