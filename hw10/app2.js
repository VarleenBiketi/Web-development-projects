const http = require('http');
const fs = require('fs');
const { MongoClient } = require('mongodb');

const server = http.createServer(async (req, res) => {
  if (req.method === 'GET' && req.url === '/') {
    // Serve the HTML form
    fs.readFile('stock.html', 'utf8', (err, data) => {
      if (err) {
        res.writeHead(500, { 'Content-Type': 'text/plain' });
        res.end('Internal Server Error');
        return;
      }

      res.writeHead(200, { 'Content-Type': 'text/html' });
      res.end(data);
    });
  } else if (req.method === 'POST' && req.url === '/lookup') {
    let body = '';

    req.on('data', (chunk) => {
      body += chunk;
    });

    req.on('end', async () => {
      // Parse form data from the request body
      const { searchInput, searchType } = parseFormData(body);

      // Connect to MongoDB
      const db = await MongoClient.connect("mongodb+srv://VarleenBiketi:cDCZ6yzmUKJuooPm@cluster0.4p6cl3u.mongodb.net/?retryWrites=true&w=majority");
      const collection = db.db('stockApp').collection('Companies');

      // Build the query based on form input
      const query = {};
      query[searchType === 'symbol' ? 'stockTicker' : 'companyName'] = { $regex: new RegExp(searchInput, 'i') };

      // Execute the query
      const result = await collection.find(query).toArray();

      // Render results dynamically
      res.writeHead(200, { 'Content-Type': 'text/html' });
      res.write('<h2>Results</h2>');

      if (result.length === 0) {
        res.write('<p>No matching results found.</p>');
      } else {
        res.write('<ul>');
        result.forEach(({ companyName, stockTicker, stockPrice }) => {
          res.write(`<li>${companyName} (${stockTicker}): $${stockPrice.toFixed(2)}</li>`);
        });
        res.write('</ul>');
      }

      res.end();
      db.close();
    });
  } else {
    res.writeHead(404, { 'Content-Type': 'text/plain' });
    res.end('Not Found');
  }
});

// Function to parse form data from the request body
const parseFormData = (data) => {
  const formData = {};
  data.split('&').forEach((pair) => {
    const [key, value] = pair.split('=');
    formData[key] = decodeURIComponent(value.replace(/\+/g, ' '));
  });
  return formData;
};

const port = 8080;
server.listen(port, () => {
  console.log(`Server listening at http://localhost:${port}`);
});
