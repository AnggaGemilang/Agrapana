#include <PubSubClient.h>
#include <ArduinoJson.h>
#include <ESP8266WiFi.h>

#define MSG_BUFFER_SIZE (50)
#define LEDPin D1
#define LightSensorPin A0
#define ssid "polban_staff"
#define password "12polban34"

//#define mqtt_broker "broker.emqx.io"
//#define mqtt_username "emqx"
//#define mqtt_password "public"
//#define mqtt_port 1883

#define mqtt_broker "e18cd11e.us-east-1.emqx.cloud"
#define mqtt_username "AnggaGemilang"
#define mqtt_password "4ngg4Gem!l4ng"
#define mqtt_port 15089

WiFiClient wifiClient;
PubSubClient mqttClient(wifiClient);

unsigned long lastMsg = 0;
char msg[MSG_BUFFER_SIZE];

// common
char power[25] = "";
char is_planting[4] = "";
char plant_name[25] = "";
char category[25] = "";
char started_planting[25] = "";

// configuration
char temperatureConfiguration[10] = "";
char gas[8] = "";
char pump[8] = "";
char modes[10] = "";
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

  Serial.print(power);
  Serial.println();
    
  if (!strcmp(power, "on")) {
    digitalWrite(LEDPin, HIGH);
  } 
  if (!strcmp(power, "off")) {
    digitalWrite(LEDPin, LOW);
  }
}

void setup() {

  Serial.begin(9600);
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.println("Connecting to WiFi..");
  }
  Serial.println("Connected to the WiFi network!");

  pinMode(LEDPin, OUTPUT);
  pinMode(LightSensorPin, INPUT);

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
  if (!mqttClient.connected()) {
    reconnect();
  }
  mqttClient.loop();


  unsigned long now = millis();
  if (now - lastMsg > 10000) {
    int lightData = analogRead(LightSensorPin);

    lastMsg = now;

    snprintf (msg, MSG_BUFFER_SIZE, "%ld", lightData);

    // =======================================================

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

    doc2["temperature"] = msg;
    doc2["ph"] = msg;
    doc2["gas"] = msg;
    doc2["nutrition"] = msg;
    doc2["nutrition_volume"] = msg;
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
    
  }

}
