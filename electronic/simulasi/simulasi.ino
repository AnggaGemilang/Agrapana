#include <PubSubClient.h>
#include <ArduinoJson.h>
#include <WiFi.h>
#include <HTTPClient.h>

#define MSG_BUFFER_SIZE (50)
#define WIFI_SSID "SPEEDY"
#define WIFI_PASSWORD "suherman"
#define MQTT_SERVER "test.mosquitto.org"

HTTPClient httpMainDevice, httpSupportDevice;
WiFiClient espClient;
PubSubClient client(espClient);

char CLIENT_CODE[50] = "d02557b0-c0fa-415e-924c-ac624a691c0d";
char FIELD_CODE[50] = "cd3eb1ad-f3ee-4fa4-bf19-0e4f7da89746";
char SERVER1[58] = "https://arnesys.agrapana.tech/api/monitoring-main-devices";
char SERVER2[61] = "https://arnesys.agrapana.tech/api/monitoring-support-devices";
char topic[100] = "";
long lastMsg = 0;
long lastMsg2 = 0;

char output[200];

void setup_wifi() {
  Serial.print("Connecting to ");
  Serial.print(WIFI_SSID);
  Serial.println();

  WiFi.mode(WIFI_STA);
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  randomSeed(micros());

  Serial.println("");
  Serial.println("WiFi connected");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
}

void reconnect() {
  while (!client.connected()) {
    Serial.print("Attempting MQTT connection...");
    String clientId = "ESP32Client-";
    clientId += String(random(0xffff), HEX);
    if (client.connect(clientId.c_str())) {
      Serial.println("connected");
    } else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println(" try again in 5 seconds");
      delay(5000);
    }
  }
}

void setup() {
  Serial.begin(9600);
  setup_wifi();
  client.setServer(MQTT_SERVER, 1883);
}

void loop() {
  if (!client.connected()) {
    reconnect();
  }
  client.loop();

  unsigned long now = millis();

  if (now - lastMsg > 5000) {
    
    lastMsg = now;

    Serial.println("");

//    Kirim data perangkat utama

    StaticJsonDocument<96> doc;

    doc["monitoring"]["warmth"] = random(0, 100);
    doc["monitoring"]["humidity"] = random(0, 100);
    doc["monitoring"]["pressure"] = random(0, 100);
    doc["monitoring"]["wind_speed"] = random(0, 100);
    doc["monitoring"]["rainfall"] = random(0, 100);
    doc["monitoring"]["light_intensity"] = random(0, 100);
    serializeJson(doc, output); 

    strcpy(topic, "arnesys/");
    strcat(topic, CLIENT_CODE);
    strcat(topic, "/");
    strcat(topic, FIELD_CODE);
    strcat(topic, "/utama");
    Serial.print("Topic: ");
    Serial.println(topic);
    
    client.publish(topic, output);
    Serial.print("Publish message: ");
    Serial.println(output);

//    Kirim data perangkat pendukung

    Serial.println("");

    StaticJsonDocument<200> doc2;

    doc2["monitoring"]["warmth"] = random(0, 100);
    doc2["monitoring"]["moisture"] = random(0, 100);
    doc2["monitoring"]["ph"] = random(0, 100);
    doc2["monitoring"]["nitrogen"] = random(0, 100);
    doc2["monitoring"]["phosphor"] = random(0, 100);
    doc2["monitoring"]["kalium"] = random(0, 100);
    serializeJson(doc2, output); 

    strcpy(topic, "arnesys/");
    strcat(topic, CLIENT_CODE);
    strcat(topic, "/");
    strcat(topic, FIELD_CODE);
    strcat(topic, "/pendukung/1");
    Serial.print("Topic: ");
    Serial.println(topic);
    
    client.publish(topic, output);
    Serial.print("Publish message: ");
    Serial.println(output);

    Serial.println("");
    Serial.println("=====================================");
    
  }

  if (now - lastMsg2 > 10000) {
    
    lastMsg2 = now;

    Serial.println("");

//    Kirim data perangkat utama

    httpMainDevice.begin(SERVER1);

    httpMainDevice.addHeader("Content-Type", "application/x-www-form-urlencoded");
    String httpRequestData = "&wind_temperature=" + String(random(50)) + "&wind_humidity=" + String(random(50)) + "&wind_pressure=" + String(random(50)) + "&wind_speed=" + String(random(50)) + "&rainfall=" + String(random(50)) + "&light_intensity=" + String(random(50)) + "&field_id=" + String(CLIENT_CODE);
    int httpResponseCode = httpMainDevice.POST(httpRequestData);
           
    Serial.print("HTTP Response code is: ");
    Serial.println(httpResponseCode);
    httpMainDevice.end();

//    Kirim data perangkat pendukung

    Serial.println("");

    httpSupportDevice.begin(SERVER2);

    httpSupportDevice.addHeader("Content-Type", "application/x-www-form-urlencoded");
    String httpRequestData2 = "&number_of=1&soil_temperature=" + String(random(50)) + "&soil_humidity=" + String(random(50)) + "&soil_ph=" + String(random(50)) + "&soil_nitrogen=" + String(random(50)) + "&soil_phosphor=" + String(random(50)) + "&soil_kalium=" + String(random(50)) + "&field_id=" + String(CLIENT_CODE);
    int httpResponseCode2 = httpSupportDevice.POST(httpRequestData2);
    
    Serial.print("HTTP Response code is: ");
    Serial.println(httpResponseCode2);
    httpSupportDevice.end();

    Serial.println("");
    Serial.println("=====================================");
    
  }
  
}
