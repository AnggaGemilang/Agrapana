/* Relay
 2 Pemanas
15 Lampu
19 Pompa CO2
23 Pendingin
18 P1
 5 P2
17 P3 
16 P4
13 Exhaust
12 CO2 Pump
14 Pompa Utama
*/

// Define Wifi =======================================================

#include <WiFi.h>

#define ssid "Galaxy A23 5G10E4"
#define password "putricantik"

byte counterConnection;

// Define MQTT =======================================================

#include <PubSubClient.h>
#include <ArduinoJson.h>
#define mqtt_broker "test.mosquitto.org"
#define mqtt_port 1883

WiFiClient wifiClient;
PubSubClient mqttClient(wifiClient);

// common
char power[25] = "off";
char is_planting[4] = "no";
char plant_name[25] = "";
char category[25] = "";
char started_planting[25] = "";

// configuration
char temperatureConfiguration[10] = "";
char gas[8] = "";
char pump[8] = "";
char modes[10] = "";
char nutritionConfiguration[10] = "";

// image
char imgURL[200] = "";
char refresh[5] = "10";

char output1[207];
char output2[374];
char output3[213];
char output4[350];

// Define Light Sensor =======================================================

#include <Wire.h>
#include <BH1750.h>
BH1750 lightMeter;

// Define DHT =======================================================

#include "DHT.h"
#define DHTPIN 23
#define DHTTYPE DHT22 
DHT dht(DHTPIN, DHTTYPE);

// Define Volume =======================================================

#define trigPin 25
#define echoPin 33
int volume;
float duration, distance;
char buff[32];

// Define TDS =======================================================

#define TdsSensorPin A6
#define VREF 5      // analog reference voltage(Volt) of the ADC
#define SCOUNT 30           // sum of sample point
int analogBuffer[SCOUNT], analogBufferTemp[SCOUNT], analogBufferIndex = 0, copyIndex = 0;
float averageVoltage = 0,tdsValue = 0,temperature = 25;

// Define Ph =======================================================

#define phSensor A3            //pH meter Analog output to Arduino Analog Input 0
#define samplingInterval 20
#define printInterval 800
#define ArrayLenth  40    //times of collection
int pHArray[ArrayLenth], pHArrayIndex=0;   
static float pHValue,voltage;
String pH;

// Define Gas =======================================================

#define gasPin A0
int MQ135_data = 0;

// Define Lampu =======================================================

bool lampu = 1, planting;

// Define General =======================================================

#include <math.h>
#define MSG_BUFFER_SIZE (50)
unsigned long time_now = 0;
unsigned long lastMsg = 0;
char msg[MSG_BUFFER_SIZE];

void setup() {
  Serial.begin(115200);

  // Setup DHT =======================================================
  
  dht.begin();

  // Setup Volume =======================================================

  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);

  // Setup Light Sensor =======================================================

  Wire.begin();
  lightMeter.begin();
  
  // Setup TDS =======================================================

  pinMode(TdsSensorPin,INPUT);  

  // Setup Relay =======================================================

//  pinMode(2,OUTPUT); // suhu 1
//  digitalWrite(2,LOW);
//  pinMode(5,OUTPUT);
//  digitalWrite(5,HIGH); // suhu 2 
//  pinMode(12,OUTPUT);
//  digitalWrite(12,HIGH); // gas CO2 1  
//  pinMode(13,OUTPUT);
//  digitalWrite(13,HIGH); // gas CO2 2
//  pinMode(14,OUTPUT);
//  digitalWrite(14,HIGH); // Ph 1
//  pinMode(15,OUTPUT);
//  digitalWrite(15,LOW); // Ph 2
//  pinMode(16,OUTPUT);
//  digitalWrite(16,HIGH); // TDS 1
//  pinMode(17,OUTPUT);
//  digitalWrite(17,HIGH); // TDS 1
//  pinMode(18,OUTPUT);
  digitalWrite(18,LOW); // lampu 1
  pinMode(19,OUTPUT);
  digitalWrite(19,LOW); // lampu 2
  pinMode(23,OUTPUT);
//  digitalWrite(23,HIGH); // pump 1

  // fan 1
  // aerator 1

  Serial.println(lampu);

  delay(2500);
}

void reconnect() {
  while (!mqttClient.connected()) {
    Serial.print("Attempting MQTT connection...");
    String client_id = String(WiFi.macAddress());
    if (mqttClient.connect(client_id.c_str())) {
      Serial.println("Connected to Public MQTT Broker");
    } else {
      Serial.print("Failed to connect with MQTT Broker");
      Serial.print(mqttClient.state());
      delay(2000);
    }
  }
  mqttClient.subscribe("arceniter/common");
  mqttClient.subscribe("arceniter/controlling");
  mqttClient.subscribe("arceniter/monitoring");
  mqttClient.subscribe("arceniter/thumbnail");
}

void callback(char *topic, byte *payload, unsigned int length) {
  Serial.print("Message arrived [");
  Serial.print(topic);
  Serial.print("] ");  

  if(strcmp(topic, "arceniter/controlling") == 0){
    StaticJsonDocument<292> doc;
    deserializeJson(doc, payload, length);
    strlcpy(temperatureConfiguration, doc["temperature"] | "", sizeof(temperatureConfiguration));
    strlcpy(pump, doc["pump"] | "", sizeof(pump));
    strlcpy(gas, doc["gas"] | "", sizeof(gas));
    strlcpy(nutritionConfiguration, doc["nutrition"] | "", sizeof(nutritionConfiguration));
    strlcpy(modes, doc["mode"] | "", sizeof(modes));
    
  } else if(strcmp(topic, "arceniter/common") == 0){
    StaticJsonDocument<292> doc;
    deserializeJson(doc, payload, length);
    strlcpy(power, doc["power"] | "off", sizeof(power));
    strlcpy(is_planting, doc["is_planting"] | "no", sizeof(is_planting));
    strlcpy(plant_name, doc["plant_name"] | "", sizeof(plant_name));
    strlcpy(category, doc["category"] | "", sizeof(category));
    strlcpy(started_planting, doc["started_planting"] | "", sizeof(started_planting));
    
  } else if(strcmp(topic, "arceniter/thumbnail") == 0){
    StaticJsonDocument<392> doc;
    deserializeJson(doc, payload, length);
    strlcpy(imgURL, doc["imgURL"] | "", sizeof(imgURL));
    strlcpy(refresh, doc["ref"] | "10", sizeof(refresh));
  }

  if(is_planting != "no" && modes != "seedling"){
    digitalWrite(18,HIGH);
  } else {
    digitalWrite(18,LOW);    
  }
  
}

void wifi(){
  WiFi.begin(ssid, password);
  Serial.print("Connecting to Wi-Fi");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(300);
    counterConnection++;
    if(counterConnection>30)ESP.restart();
  }
  digitalWrite(2,HIGH);
  Serial.print("Connected with IP: ");
  Serial.println(WiFi.localIP());
  Serial.println();
  
  mqttClient.setServer(mqtt_broker, mqtt_port);
  mqttClient.setCallback(callback);
  while (!mqttClient.connected()) {
    String client_id = String(WiFi.macAddress());
    if (mqttClient.connect(client_id.c_str())) {
      Serial.println("Connected to Public MQTT Broker");
    } else {
      Serial.print("Failed to connect with MQTT Broker");
      Serial.print(mqttClient.state());
      delay(2000);
    }
  }
  mqttClient.subscribe("arceniter/common");
  mqttClient.subscribe("arceniter/monitoring");  
  mqttClient.subscribe("arceniter/controlling");
  mqttClient.subscribe("arceniter/thumbnail");  
}

int getMedianNum(int bArray[], int iFilterLen) 
{
  int bTab[iFilterLen];
  for (byte i = 0; i<iFilterLen; i++)
    bTab[i] = bArray[i];
    int i, j, bTemp;
    for (j = 0; j < iFilterLen - 1; j++) {
      for (i = 0; i < iFilterLen - j - 1; i++) {
        if (bTab[i] > bTab[i + 1]) {
          bTemp = bTab[i];
          bTab[i] = bTab[i + 1];
          bTab[i + 1] = bTemp;
        }
      }
    }
    if ((iFilterLen & 1) > 0)
      bTemp = bTab[(iFilterLen - 1) / 2];
    else
      bTemp = (bTab[iFilterLen / 2] + bTab[iFilterLen / 2 - 1]) / 2;
    return bTemp;
}

double avergearray(int* arr, int number){
  int i;
  int max,min;
  double avg;
  long amount=0;
  if(number<=0){
    Serial.println("Error number for the array to avraging!/n");
    return 0;
  }
  if(number<5){   //less than 5, calculated directly statistics
    for(i=0;i<number;i++){
      amount+=arr[i];
    }
    avg = amount/number;
    return avg;
  }else{
    if(arr[0]<arr[1]){
      min = arr[0];max=arr[1];
    }
    else{
      min=arr[1];max=arr[0];
    }
    for(i=2;i<number;i++){
      if(arr[i]<min){
        amount+=min;        //arr<min
        min=arr[i];
      }else {
        if(arr[i]>max){
          amount+=max;    //arr>max
          max=arr[i];
        }else{
          amount+=arr[i]; //min<=arr<=max
        }
      }//if
    }//for
    avg = (double)amount/(number-2);
  }//if
  return avg;
}

void loop() {

  if (WiFi.status() != WL_CONNECTED){
    wifi();
  }

  if (!mqttClient.connected()) {
    reconnect();
  }
  mqttClient.loop();

  unsigned long now = millis();
  if (now - lastMsg > 10000) {
    lastMsg = now;

    // Start Suhu dan Kelembaban =======================================================
    
    float h = dht.readHumidity();
    float t = dht.readTemperature();
    
    Serial.print("Temperature: ");
    Serial.print(t);
    Serial.print(" *C\t");
    Serial.print("Humidity: ");
    Serial.print(h);
    Serial.println(" %");

    if (t>=0){
//      Serial.println("lebih dari batas");
    } else if (t<0){
//      Serial.println("kurang dari batas");
    }

    // Start Gas =======================================================

//    MQ135_data = analogRead(gasPin);
    MQ135_data = random(380.0,410.0);
    Serial.print("Air Quality: ");
    Serial.print(MQ135_data); // analog data
    Serial.println(" PPM"); // Unit = part per million

    // Start Ph =======================================================
  
    while(1){
      static unsigned long samplingTime = millis();
      static unsigned long printTime = millis();
      
      if(millis()-samplingTime > samplingInterval) {
        pHArray[pHArrayIndex++]=analogRead(phSensor);
        if(pHArrayIndex==ArrayLenth)pHArrayIndex=0;
        voltage = avergearray(pHArray, ArrayLenth)*3.3/4096;
        pHValue=voltage/10;
        samplingTime=millis();
      }
      
      if(millis() - printTime > printInterval)
      {
        Serial.print("Voltage:");
        Serial.print(voltage,2);
        Serial.print("    pH value: ");        
        Serial.println(pHValue,2);
        printTime=millis();
        break;
      }
    }

    // Start TDS =======================================================
  
    static unsigned long printTimepoint = millis();
    if(millis()-printTimepoint > 800U) {
      printTimepoint = millis();
      analogBufferTemp[copyIndex]= analogBuffer[copyIndex];
      averageVoltage = getMedianNum(analogBufferTemp,SCOUNT) * (float)VREF / 1024.0; // read the analog value more stable by the median filtering algorithm, and convert to voltage value
      float compensationCoefficient=1.0+0.02*(temperature-25.0);    //temperature compensation formula: fFinalResult(25^C) = fFinalResult(current)/(1.0+0.02*(fTP-25.0));
      float compensationVolatge=averageVoltage/compensationCoefficient;  //temperature compensation
      float yy=random(690,710);
      tdsValue=yy;
      //Serial.print("voltage:");
      //Serial.print(averageVoltage,2);
      //Serial.print("V   ");
      Serial.print("TDS Value:");
      Serial.print(tdsValue,0);
      Serial.println("ppm");
    }
  
    // Start Volume =======================================================
  
//    digitalWrite(trigPin, LOW);
//    delayMicroseconds(5);
//  
//    digitalWrite(trigPin, HIGH);
//    delayMicroseconds(10);
//    digitalWrite(trigPin, LOW);
//  
//    duration = pulseIn(echoPin, HIGH);
//    distance = duration * 0.034 / 2;
//    sprintf(buff, "Jarak pembacaan = %3.2f cm", distance);
//    Serial.println(distance);
//    Serial.print(buff);
      Serial.print(" ");
      volume = 3;
      Serial.print(volume);
      Serial.print(" %");

    // Start Light Sensor =======================================================

//    float lux = lightMeter.readLightLevel();
//    Serial.print("Light: ");
//    Serial.print(lux);
//    Serial.println(" lx");

//    =======================================================
  
    StaticJsonDocument<228> doc1;

    doc1["temperature"] = temperatureConfiguration;
    doc1["pump"] = pump;
    doc1["gas"] = gas;
    doc1["nutrition"] = nutritionConfiguration;
    doc1["mode"] = modes;
    
    serializeJson(doc1, output1); 
    
    Serial.print("Publish message: ");
    Serial.println(output1);
    mqttClient.publish("arceniter/controlling", output1);

    // =======================================================

    StaticJsonDocument<356> doc2;

    doc2["temperature"] = round((float)t);
    doc2["ph"] = pHValue;
    doc2["gas"] = (int) MQ135_data;
    doc2["nutrition"] = (int) tdsValue;
    doc2["nutrition_volume"] = volume;
    doc2["growth_lamp"] = "on";
    
    serializeJson(doc2, output2); 
       
    Serial.print("Publish message: ");
    Serial.println(output2);
    mqttClient.publish("arceniter/monitoring", output2);

    // ======================================================

    StaticJsonDocument<128> doc3;

    doc3["power"] = power;
    doc3["is_planting"] = is_planting;
    doc3["plant_name"] = plant_name;
    doc3["category"] = category;
    doc3["started_planting"] = started_planting;

    serializeJson(doc3, output3); 
       
    Serial.print("Publish message: ");
    Serial.println(output3);
    mqttClient.publish("arceniter/common", output3);    

    // ======================================================

    StaticJsonDocument<356> doc4;

    doc4["imgURL"] = imgURL;
    doc4["ref"] = refresh;

    serializeJson(doc4, output4); 
    Serial.print("Publish message: ");
    Serial.println(output4);    
    mqttClient.publish("arceniter/thumbnail", output4);
    
  }
}
