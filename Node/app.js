const fs = require('fs');
const readline = require('readline');
const { MongoClient } = require('mongodb');

const mongoURI = "mongodb+srv://VarleenBiketi:cDCZ6yzmUKJuooPm@cluster0.4p6cl3u.mongodb.net/?retryWrites=true&w=majority";
const dbName = 'stockApp';
const collectionName = 'Companies';

// Created MongoDB client
const client = new MongoClient(mongoURI);

// Function to parse the CSV file and insert data into the database
async function parseCSVAndInsertData() {
    const fileStream = fs.createReadStream('companies.csv');
    const rl = readline.createInterface({
      input: fileStream,
      crlfDelay: Infinity,
    });
  
    const db = client.db(dbName);
    const collection = db.collection(collectionName);
  
    // Skip the header line
    await rl[Symbol.asyncIterator]().next();
  
    for await (const line of rl) {
      const [company, ticker, price] = line.split(','); // Use ',' as the delimiter
  
      // Add a check to ensure there are enough elements in the array
      if (company && ticker && price) {
        const document = {
          companyName: company.trim(),
          stockTicker: ticker.trim(),
          stockPrice: parseFloat(price.trim()) || 0, // Set default value if price is not a valid number
        };
  
        await collection.insertOne(document);
        console.log('Inserted:', document);
      } else {
        console.log('Skipping invalid line:', line);
      }
    }
  }
  
  
  
  

// Connected to MongoDB and ran the script
async function run() {
  try {
    await client.connect();
    console.log('Connected to MongoDB');

    await parseCSVAndInsertData();
  } finally {
    await client.close();
    console.log('Disconnected from MongoDB');
  }
}

run();
