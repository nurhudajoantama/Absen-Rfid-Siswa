#include <SPI.h>
#include <MFRC522.h>

#include <ESP8266HTTPClient.h>
#include <ESP8266WiFi.h>

#include <ArduinoJson.h>

//Network SSID
const char* ssid = "YOUR_WIFI_SSID"; //ssid wifi
const char* password = "ROUR_WIFI_PASS"; //password wifi

//pengenal host (server) = IP Address komputer server
const char* host = "192.168.1.100"; //ip address
const int httpPort = 80; //port

String idAlat = "2"; //id alat setelah ditambahkan
String token = "cDIv61rN"; // token alat

String linkServer = "http://192.168.1.100/api/scan-rfid"; // ip sesuaikan dengan ip komputer

//sediakan variabel untuk RFID
#define SDA_PIN 2  //D4
#define RST_PIN 0  //D3

MFRC522 mfrc522(SDA_PIN, RST_PIN);
MFRC522::MIFARE_Key key;

void setup() {
  Serial.begin(9600);

  //setting koneksi wifi
  WiFi.hostname("NodeMCU");
  WiFi.begin(ssid, password);

  //cek koneksi wifi
  while (WiFi.status() != WL_CONNECTED)
  {
    //progress sedang mencari WiFi
    delay(500);
    Serial.print(".");
  }

  Serial.println("Wifi Connected");
  Serial.println("IP Address : ");
  Serial.println(WiFi.localIP());

  SPI.begin();
  mfrc522.PCD_Init();
  Serial.println("Dekatkan Kartu RFID Anda ke Reader");
  Serial.println();
}

void loop() {

  if ( ! mfrc522.PICC_IsNewCardPresent())
  {
    delay(1000);
    return;
  }

  if (! mfrc522.PICC_ReadCardSerial())
  {
    return;
  }

  String IDTAG = "";
  for (byte i = 0; i < mfrc522.uid.size; i++)
  {
    IDTAG += mfrc522.uid.uidByte[i];
  }
  mfrc522.PICC_HaltA();
  mfrc522.PCD_StopCrypto1();

  //kirim nomor kartu RFID untuk disimpan ke tabel tmprfid
  WiFiClient client;
  if (!client.connect(host, httpPort))
  {
    Serial.println("Connection Failed");
    return;
  }

  String Link;
  HTTPClient http;
  Link = linkServer + "?id-alat=" + idAlat + "&token=" + token + "&id-rfid=" + IDTAG ;
  http.begin(Link);

  char json[500];
  int httpCode = http.GET();
  String payload = http.getString();
  payload.toCharArray(json, 500);
  StaticJsonDocument<200> doc;
  deserializeJson(doc, json);

  const char* message = doc["message"];
  const char* nama = doc["data"]["nama"];
  const char* noInduk = doc["data"]["no_induk"];
  const char* rfidBaru = doc["data"]["rfid_baru"];

  //dapat menggunakan layar untuk menampilkan data yang ada
  
  Serial.print("message : ");
  Serial.println(message);
  if (doc["data"]) {
    if (rfidBaru) {
      Serial.print("rfid baru : ");
      Serial.println(rfidBaru);
    } else {
      Serial.print("nama : ");
      Serial.println(nama);
      Serial.print("no induk : ");
      Serial.println(noInduk);
    }
  }


  http.end();

  delay(2000);
}
