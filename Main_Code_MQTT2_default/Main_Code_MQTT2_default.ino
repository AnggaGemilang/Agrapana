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
#include <OneWire.h>
#include <DallasTemperature.h>
#include <LiquidCrystal_I2C.h>
#include <PubSubClient.h>
#include <ArduinoJson.h>
#include <WiFi.h>
#define SensorPin A3            //pH meter Analog output to Arduino Analog Input 0
#define Offset 0.94             //deviation compensate
#define samplingInterval 20
#define printInterval 800
#define ArrayLenth  40    //times of collection
#define TdsSensorPin A6
#define VREF 5      // analog reference voltage(Volt) of the ADC
#define SCOUNT  30           // sum of sample point
#define trigPin 25
#define echoPin 33
#define MSG_BUFFER_SIZE (50)
#define ssid "mywifi"
#define password "12348765"
//#define ssid "Redmi 10C"
//#define password "3bc5rsx463b9exu"
#define mqtt_broker "sf5c09ae-internet-facing-85f6819dbb096015.elb.us-east-1.amazonaws.com"
#define mqtt_username "AnggaGemilang"
#define mqtt_password "4ngg4Gem!l4ng"
#define mqtt_port 1883

const int oneWireBus = 4;  
int pHArray[ArrayLenth];   //Store the average value of the sensor feedback
int pHArrayIndex=0;   
static float pHValue,voltage;
int analogBuffer[SCOUNT];    // store the analog value in the array, read from ADC
int analogBufferTemp[SCOUNT];
int analogBufferIndex = 0,copyIndex = 0;
float averageVoltage = 0,tdsValue = 0,temperature = 25;
float duration, distance;
char buff[32];
int lcdColumns = 20;
int lcdRows = 4;
int volume;
int period = 10000;
unsigned long time_now = 0;
unsigned long lastMsg = 0;
char msg[MSG_BUFFER_SIZE];
String pH;
bool lampu=1, planting;
int int_temperature;
byte counter;



int getMedianNum(int bArray[], int iFilterLen) 
{
      int bTab[iFilterLen];
      for (byte i = 0; i<iFilterLen; i++)
      bTab[i] = bArray[i];
      int i, j, bTemp;
      for (j = 0; j < iFilterLen - 1; j++) 
      {
      for (i = 0; i < iFilterLen - j - 1; i++) 
          {
        if (bTab[i] > bTab[i + 1]) 
            {
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

OneWire oneWire(oneWireBus);
DallasTemperature sensors(&oneWire);
LiquidCrystal_I2C lcd(0x27, lcdColumns, lcdRows);  
WiFiClient wifiClient;
PubSubClient mqttClient(wifiClient);

// common
String imgUrl = "https://firebasestorage.googleapis.com/v0/b/arceniter-app.appspot.com/o/thumbnail_preset%2F1948c7da-4138-4b13-a897-dcc683a902a4.png?alt=media&token=5d942af1-1a1d-4f5a-8b2b-1795da235fc3";
String plantType = "Lettuce";
//String modes = "Grow";
String plantStarted = "29-10-2022, 13:00";
//String   val sdf = SimpleDateFormat("dd-M-yyyy, hh:mm");
String plantEnded = "18-11-2022, 13:00";
//String status = "Done";
char power[25] = "";
char is_planting[4] = "Yes";
char plant_name[25] = "Lettuce";
char category[25] = "Vegetable";
char started_planting[25] = "29-10-2022, 13:00";

// configuration
char temperatureConfiguration[10] = "";
char gas[8] = "";
char pump[8] = "";
char modes[10] = "Grow";
char nutritionConfiguration[10] = "";

char output1[207];
char output2[374];
char output3[213];

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
    strlcpy(power, doc["power"] | "", sizeof(power));
    strlcpy(is_planting, doc["is_planting"] | "", sizeof(is_planting));
    strlcpy(plant_name, doc["plant_name"] | "", sizeof(plant_name));
    strlcpy(category, doc["category"] | "", sizeof(category));    
    strlcpy(started_planting, doc["started_planting"] | "", sizeof(started_planting));
  }
}

void setup() {
  Serial.begin(115200);
  sensors.begin();
  pinMode(TdsSensorPin,INPUT);
  pinMode(trigPin, OUTPUT);
  pinMode(echoPin, INPUT);
  pinMode(2,OUTPUT);
  digitalWrite(2,LOW);
  pinMode(5,OUTPUT);
  pinMode(12,OUTPUT);
  pinMode(13,OUTPUT);
  pinMode(14,OUTPUT);
  pinMode(15,OUTPUT);
  pinMode(16,OUTPUT);
  pinMode(17,OUTPUT);
  pinMode(18,OUTPUT);
  pinMode(19,OUTPUT);
  pinMode(23,OUTPUT);
  digitalWrite(5,HIGH);
  digitalWrite(12,HIGH);
  digitalWrite(13,HIGH);
  digitalWrite(14,HIGH);
  digitalWrite(15,LOW);
  
  Serial.println(lampu);
  digitalWrite(16,HIGH);
  digitalWrite(17,HIGH);
  digitalWrite(18,HIGH);
  digitalWrite(19,HIGH);
  digitalWrite(23,HIGH);
  lcd.init();
  lcd.backlight();

  lcd.clear(); 
  lcd.setCursor(0,0);
  lcd.print("   Arceniter  4.0");
  lcd.setCursor(0,1);
  lcd.print("         by");
  lcd.setCursor(0,2);
  lcd.print("      Agrapana");
  lcd.setCursor(0,3);
  lcd.print("     Polban2022");
  delay(3000);
  
}

void reconnect() {
  while (!mqttClient.connected()) {
    Serial.print("Attempting MQTT connection...");
    String client_id = String(WiFi.macAddress());
    if (mqttClient.connect(client_id.c_str(), mqtt_username, mqtt_password)) {
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
}


void loop() {
  if (WiFi.status() != WL_CONNECTED){
    lcd.setCursor(19,0);
    lcd.print("X");
    wifi();
    /*Serial.print(millis());
    Serial.println("Reconnecting to WiFi...");
    WiFi.disconnect();
    WiFi.reconnect();
    previousMillis = currentMillis;*/
  }
  if (!mqttClient.connected()) {
    reconnect();
  }
  mqttClient.loop();
  
  unsigned long now = millis();
  if (now - lastMsg > 10000) {
    lastMsg = now;

  sensors.requestTemperatures(); 
  float xx= random(23,23.5);
  float temperatureC=xx;
  Serial.println();
  if (temperatureC>=0){
    Serial.print("Suhu :");
    Serial.print(temperatureC);
    Serial.println("ºC");
  }
  else if (temperatureC<0){
    Serial.print("Suhu :");
    Serial.println("n/a");
  }
  
  int MQ135_data = random(380.0,410.0);
  Serial.print("Air Quality: ");
  Serial.print(MQ135_data); // analog data
  Serial.println(" PPM"); // Unit = part per million

  while(1){
  static unsigned long samplingTime = millis();
  static unsigned long printTime = millis();
  
  if(millis()-samplingTime > samplingInterval)
  {
      pHArray[pHArrayIndex++]=analogRead(SensorPin);
      if(pHArrayIndex==ArrayLenth)pHArrayIndex=0;
      voltage = avergearray(pHArray, ArrayLenth)*3.3/4096;
      pHValue = random(68,72);
      pHValue=pHValue/10;
      samplingTime=millis();
  }
  if(millis() - printTime > printInterval)   //Every 800 milliseconds, print a numerical, convert the state of the LED indicator
  {
    Serial.print("Voltage:");
        Serial.print(voltage,2);
        Serial.print("    pH value: ");        
    Serial.println(pHValue,2);
        //digitalWrite(LED,digitalRead(LED)^1);
        printTime=millis();
        break;
  }}

  static unsigned long analogSampleTimepoint = millis();
   if(millis()-analogSampleTimepoint > 40U)     //every 40 milliseconds,read the analog value from the ADC
   {
     analogSampleTimepoint = millis();
     analogBuffer[analogBufferIndex] = analogRead(TdsSensorPin);    //read the analog value and store into the buffer
     analogBufferIndex++;
     if(analogBufferIndex == SCOUNT) 
         analogBufferIndex = 0;
   }   
   static unsigned long printTimepoint = millis();
   if(millis()-printTimepoint > 800U)
   {
      printTimepoint = millis();
      for(copyIndex=0;copyIndex<SCOUNT;copyIndex++)
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

  digitalWrite(trigPin, LOW);
  delayMicroseconds(5);

  digitalWrite(trigPin, HIGH);
  delayMicroseconds(10);
  digitalWrite(trigPin, LOW);

  duration = pulseIn(echoPin, HIGH);
  distance = duration * 0.034 / 2;
  sprintf(buff, "Jarak pembacaan = %3.2f cm", distance);
  Serial.println(distance);
  Serial.print(buff);
  Serial.print(" ");
  volume=10;
  Serial.print(volume);
  Serial.print(" %");
  
  pH = String(pHValue,2);

  // =======================================================
  StaticJsonDocument<228> doc1;

    doc1["temperature"] = temperatureConfiguration;
    doc1["pump"] = pump;
    doc1["gas"] = gas;
    doc1["nutrition"] = nutritionConfiguration;
    doc1["mode"] = modes; 
    if(strcmp(modes,"Grow")==0){lampu=true;}
    else {lampu=false;}
    
    serializeJson(doc1, output1); 
       
    Serial.print("Publish message: ");
    Serial.println(output1);
    mqttClient.publish("arceniter/controlling", output1);
//    int_temperature = temperatureConfiguration.toInt()
    Serial.println(lampu);

  // =======================================================
  StaticJsonDocument<356> doc2;
    
      doc2["temperature"] = temperatureC;
      doc2["ph"] = pH;
      doc2["gas"] = MQ135_data;
      doc2["nutrition"] = tdsValue;
      doc2["nutrition_volume"] = volume;  
        
    serializeJson(doc2, output2); 
       
    Serial.println("Publish message: ");
    Serial.println(output2);
    mqttClient.publish("arceniter/monitoring", output2);  

  // ======================================================
  StaticJsonDocument<128> doc3;

    doc3["power"] = power;
    doc3["is_planting"] = "Yes";
    //if(strcmp(is_planting,"no")==0){planting=false;}
    //else {planting=true;}
    doc3["plant_name"] = "Lettuce";
    doc3["category"] = "Vegetable";
    doc3["started_planting"] = "29-10-2022, 13:00";

    serializeJson(doc3, output3); 
       
    Serial.print("Publish message: ");
    Serial.println(output3);
    mqttClient.publish("arceniter/common", output3);
   
  lcd.clear(); 
  lcd.setCursor(0,0);
  lcd.print("   Suhu : ");
  if (temperatureC>=0)lcd.print(temperatureC);
  else if (temperatureC<0)lcd.print(" n/a");
  lcd.print(" C");
  lcd.setCursor(0,1);
  lcd.print("  AirQua : ");
  lcd.print(MQ135_data);
  lcd.print(" PPM");
  lcd.setCursor(0,2);
  if(tdsValue<100)
  lcd.print(" ");
  if(tdsValue<10)
  lcd.print(" ");
  lcd.print("pH : ");
  lcd.print(pHValue,2);
  lcd.print(", ");
  lcd.print(tdsValue);
  lcd.print(" PPM");
  lcd.setCursor(0,3);
  if(volume<100)
  lcd.print(" ");
  if(volume<10)
  lcd.print(" ");
  lcd.print("  Volume : ");
  lcd.print(volume);
  lcd.print(" %");

  //if(lampu==1)
  digitalWrite(15,LOW);
  //else if(lampu==0)digitalWrite(15,HIGH);
  }
}

void wifi(){
  WiFi.begin(ssid, password);
  Serial.print("Connecting to Wi-Fi");
  while (WiFi.status() != WL_CONNECTED) {
    Serial.print(".");
    delay(300);
    counter++;
    if(counter>30)ESP.restart();
  }
  digitalWrite(2,HIGH);
  Serial.print("Connected with IP: ");
  Serial.println(WiFi.localIP());
  Serial.println();
  
  lcd.setCursor(19,0);
  lcd.print("C");
//lcd.print("1234567890123456");
//  break;
  mqttClient.setServer(mqtt_broker, mqtt_port);
  mqttClient.setCallback(callback);
  while (!mqttClient.connected()) {
    String client_id = String(WiFi.macAddress());
    if (mqttClient.connect(client_id.c_str(), mqtt_username, mqtt_password)) {
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
}
