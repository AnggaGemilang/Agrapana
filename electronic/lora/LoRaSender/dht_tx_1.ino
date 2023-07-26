/*
Algorithm
1. Baca nilai suhu
2. Baca nilai kelembapan
3. Tampilkan data suhu di LCD
4. Tampilkan data kelembapan di LCD
5. kirim data suhu ke gateway melalui Lora
6. kirim data kelembapan ke gateway melalui Lora
*/

// Library
#include "src/DHT-master/dht.h"
#include <SPI.h>
#include <Wire.h>
#include <Adafruit_GFX.h>
#include <Adafruit_SSD1306.h>
#include <LoRa.h>

#include <ArduinoJson.h>
// Define Pin

#define DHT22_PIN 3

#define SCREEN_WIDTH 128    // OLED display width, in pixels
#define SCREEN_HEIGHT 64    // OLED display height, in pixels
#define OLED_RESET -1       // Reset pin # (or -1 if sharing Arduino reset pin)
#define SCREEN_ADDRESS 0x3C ///< See datasheet for Address; 0x3D for 128x64, 0x3C for 128x32

#define ss 10
#define rst 9
#define dio0 8

// Variabel
dht DHT;
Adafruit_SSD1306 display(SCREEN_WIDTH, SCREEN_HEIGHT, &Wire, OLED_RESET);

float dataSuhu;
float dataKelembapan;

int counter = 0;

// String Message = "NULL";
static char userInput[50];
byte msgCount = 0;     // count of outgoing messages
byte MasterNode = 111; // Master Node
byte myNode = 1;       // Node1

StaticJsonDocument<70> out;
// Baca nilai Suhu
void readTemp()
{

    // Serial.print("Nilai Suhu = ");
    // Serial.println(dataSuhu, 1);
}

// Baca nilai kelembapan
void readHumidity()
{

    // Serial.print("Nilai Kelembapan = ");
    // Serial.println(dataKelembapan, 1);
}

// Tampilkan data Suhu di LCD
void displayTempHumidity_LCD()
{
    display.drawLine(1, 10, 128, 10, SSD1306_WHITE);
    display.setTextColor(WHITE);
    display.setTextSize(0.5);
    display.setCursor(1, 1);
    display.println("     Node 1");
    display.setCursor(1, 13);
    display.println(" Temperatur : ");
    display.setCursor(1, 23);
    display.println(" Kelembapan : ");
    display.setCursor(80, 13);
    display.println(dataSuhu);
    display.setCursor(80, 23);
    display.println(dataKelembapan);
    display.setCursor(1, 33);
    display.println(" Terkirim : " + String(msgCount));
    display.display();
    display.clearDisplay();

}
void lora_sent_LCD()
{

}
// Kirim data suhu ke gateway
void sendMessage(String outgoingMsg, byte destination, byte sender)
{
    // LoRa.beginPacket();               // start packet
    // LoRa.write(destination);          // add destination address
    // LoRa.write(sender);               // add sender address
    // LoRa.write(msgCount);             // add message ID
    // LoRa.write(outgoingMsg.length()); // add payload length
    // LoRa.print(outgoingMsg);          // add payload
    // LoRa.endPacket();                 // finish packet and send it

    // Serial.print("destination   : ");
    // Serial.println(destination);
    // Serial.print("sender        : ");
    // Serial.println(sender);
    // Serial.print("outgoingMsgId : ");
    // Serial.println(msgCount);
    // Serial.print("outgoingLength: ");
    // Serial.println(outgoingMsg.length());
    // Serial.print("outgoingMsg   : ");
    // Serial.println(outgoingMsg);
    // Serial.println("");

    msgCount++; // increment message ID
}

void introLCD()
{
    display.clearDisplay();
    display.drawLine(1, 10, 128, 10, SSD1306_WHITE);

    display.setTextColor(WHITE);
    display.setTextSize(0.5);

    display.setCursor(1, 1);
    display.println("   Tugas Akhir LoRa");
    display.setCursor(1, 13);
    display.println("     Putri Ismi A");
    display.setCursor(1, 23);
    display.println("      191624021");

    display.display();
    delay(2000);
    display.clearDisplay();
}
void LoRa_OK_LCD()
{
    display.clearDisplay();
    display.drawLine(1, 10, 128, 10, SSD1306_WHITE);

    display.setTextColor(WHITE);
    display.setTextSize(0.5);

    display.setCursor(1, 1);
    display.println("   Tugas Akhir LoRa");
    display.setCursor(1, 13);
    display.println("     LoRA OK");

    display.display();
    delay(2000);
    display.clearDisplay();
}
void setup()
{
    // setup debug
    // Serial.begin(115200);
    // Serial.println("Serial  OK");
    // setup LCD
    if (!display.begin(SSD1306_SWITCHCAPVCC, SCREEN_ADDRESS))
    {
        // Serial.println(F("SSD1306 allocation failed"));
        for (;;)
            ; // Don't proceed, loop forever
    }

    // setup pembacaan suhu dan Kelembapan
    // Serial.print("LIBRARY VERSION: ");
    // Serial.println(DHT_LIB_VERSION);

    introLCD();

    // setup LoRa
    LoRa.setPins(ss, rst, dio0);
    while (!LoRa.begin(915E6))
    {
        // Serial.println(".");
        delay(500);
    }
    // LoRa.setSyncWord(0xF3);
    // Serial.println("LoRa Initializing OK!");
    LoRa_OK_LCD();
    
}

void loop()
{
    DHT.read22(DHT22_PIN);
    dataSuhu = DHT.temperature;
    dataKelembapan = DHT.humidity;
    displayTempHumidity_LCD();
    delay(2000);
    send_json();
    serializeJson(out, userInput);
    LoRa.beginPacket(); // start packet
    // LoRa.write(userInput);
    // LoRa.write(userInput.length()); // add payload length
    LoRa.print(userInput); // add payload
    // LoRa.write(out);    // add payload
    LoRa.endPacket();
    msgCount++;
    // Message = out;
    // sendMessage(Message, MasterNode, myNode);
    out.clear();
    delay(2000);
}

void send_json()
{
    out["id"] = myNode;          // status humidifier on=1 / off=0
    out["suhu"] = dataSuhu;      // data temperature (float)
    out["hum"] = dataKelembapan; // display tidak menampilkan temperature. nilai temp data obsolete
                                 // serializeJson(out, Serial);

    // Serial.println("");
}
