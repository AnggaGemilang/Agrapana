#include <SPI.h>
#include <LoRa.h>
#include <ArduinoJson.h>
#include <WiFi.h>              
#include <FirebaseESP32.h>
#define ss 5
#define rst 14
#define dio0 2
#define FIREBASE_HOST "https://lora-monitor-48765-default-rtdb.firebaseio.com/"
#define FIREBASE_AUTH "AIzaSyAg_ZLBg6SQ5kw-5Y9lhDCe59bu6lWbe1w"            
#define WIFI_SSID "Galaxy M33 5G"                                  
#define WIFI_PASSWORD "anggaganteng"
FirebaseData fbdo;
String LoRaData;
StaticJsonDocument<70> in;
float command_rcvd_temp;
float command_rcvd_hum;
int command_rcvd_id;
int rssi;
void setup()
{
    // initialize Serial Monitor
    Serial.begin(115200);
    while (!Serial)
        ;
    Serial.println("LoRa Receiver");
    LoRa.setPins(ss, rst, dio0);
    while (!LoRa.begin(915E6))
    {
        Serial.println(".");
        delay(500);
    }
    // LoRa.setSyncWord(0xF3);
    Serial.println("LoRa Initializing OK!");
    
//    WiFi.begin(WIFI_SSID, WIFI_PASSWORD);                                  
//    Serial.print("Connecting to ");
//    Serial.print(WIFI_SSID);
//    while (WiFi.status() != WL_CONNECTED) 
//    {
//      Serial.print(".");
//      delay(500);
//    }
// 
//    Serial.println();
//    Serial.print("Connected");
//    Serial.print("IP Address: ");
//    Serial.println(WiFi.localIP());
//    Firebase.begin(FIREBASE_HOST, FIREBASE_AUTH);
}
void loop()
{
    int packetSize = LoRa.parsePacket();
    if (packetSize)
    {
        while (LoRa.available())
        {
            Serial.print(" Sabihis ");
            LoRaData = LoRa.readString();
            rssi = LoRa.packetRssi();
            Serial.print(" with RSSI ");
            Serial.print(rssi);
            Serial.println();
            rcvCommand();
        }
        Serial.println();
    }
}
void rcvCommand()
{
    Serial.println(LoRaData);
    deserializeJson(in, LoRaData);
    command_rcvd_id = in["id"];
    command_rcvd_temp = in["suhu"];
    command_rcvd_hum = in["hum"];
    Serial.print("id :");
    Serial.println(command_rcvd_id);
    Serial.print("suhu :");
    Serial.println(command_rcvd_temp);
    Serial.print("humidity :");
    Serial.println(command_rcvd_hum);
//    Firebase.setFloat(fbdo,"/ID", command_rcvd_id);
//    if (command_rcvd_id==1){
//      Firebase.setFloat(fbdo,"/Suhu1", command_rcvd_temp);
//      Firebase.setFloat(fbdo,"/Kelembaban1", command_rcvd_hum);
//    }
//    if (command_rcvd_id==2){
//      Firebase.setFloat(fbdo,"/Suhu2", command_rcvd_temp);
//      Firebase.setFloat(fbdo,"/Kelembaban2", command_rcvd_hum);
//    }
//    if (command_rcvd_id==3){
//      Firebase.setFloat(fbdo,"/Suhu3", command_rcvd_temp);
//      Firebase.setFloat(fbdo,"/Kelembaban3", command_rcvd_hum);
//    }
}
