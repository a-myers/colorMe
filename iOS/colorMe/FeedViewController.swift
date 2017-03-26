//
//  FeedViewController.swift
//  colorMe
//
//  Created by Clayton Webb on 3/25/17.
//  Copyright © 2017 Andrew Myers. All rights reserved.
//

import UIKit

class FeedCell: UITableViewCell {
    
    @IBOutlet weak var colorWell: UIView!
    @IBOutlet weak var nameLabel: UILabel!
    
}

class FeedViewController: UITableViewController, NSURLConnectionDelegate{
	
	@IBOutlet var tblView: UITableView!
	//var data: NSMutableData! = NSMutableData()
	
	var people = Array<Person>()
	
	enum MyError : Error {
		case RuntimeError(String)
	}
	func handleRefresh(refreshControl: UIRefreshControl)
	{
		//people = Array<Person>()
		
		self.refresh()
		
		refreshControl.endRefreshing()
	}

	
	override func viewDidLoad() {
		
		self.refreshControl?.addTarget(self, action: #selector(handleRefresh), for: UIControlEvents.valueChanged)
		
		//self.refreshControl?.beginRefreshing()
		
		//people = Array<Person>()
		refresh()
		
		//self.tblView.reloadData()
		
		//self.handleRefresh(refreshControl: self.refreshControl!)
		
	}
	
	override func viewDidAppear(_ animated: Bool) {
		refresh()
		
		self.tableView.reloadData()
		
		//self.handleRefresh(refreshControl: self.refreshControl!)
	}
	
    override func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: "FeedCell", for: indexPath) as! FeedCell
		
		let persona: Person = people[indexPath.row]
		
		cell.nameLabel.text = persona.lname
		cell.colorWell.backgroundColor = UIColor.init(red: CGFloat(persona.red / 255.0), green: CGFloat(persona.green/255.0), blue: CGFloat(persona.blue/255.0), alpha: 1.0)
		print("Index %i", indexPath.row)
        return cell
    }
	
	override func tableView(_ tableView: UITableView, numberOfRowsInSection section: Int) -> Int {
		print("Num %i", people.count)
		return people.count
	}
	
	override func numberOfSections(in tableView: UITableView) -> Int {
		return 1
	}
	
	func refresh(){
		let urlString = "http://174.138.95.169/json.php"
		
		let url = URL(string: urlString)
		URLSession.shared.dataTask(with:url!) { (data, response, error) in
			if error != nil {
				print(error)
			} else {
				do {
					
					let parsedData = try JSONSerialization.jsonObject(with: data!, options: []) as! Array<NSDictionary>
					
					//print(parsedData)
					var peeps = Array<Person>()
					
					for p in parsedData{
						
						var a: Person = Person()
						
						a.color = ""
						a.fname = ""
						a.lastChange = ""
						a.lname = ""
						
						if let color = p["color"] as? String{
							a.color = color
						}
						if let fname = p["fname"] as? String{
							a.fname = fname
						}
						if let lastChange = p["lastChange"] as? String{
							a.lastChange = lastChange
						}
						if let lname = p["lname"] as? String{
							a.lname = lname
						}
						
						a.red = 0.0
						a.blue = 0.0
						a.green = 0.0
						if let red = p["r"] as? Double, let green = p["g"] as? Double, let blue = p["b"] as? Double {
							a.red = red
							a.green = green
							a.blue = blue
						}
						
						peeps.append(a)
					}
					self.people = peeps;
					print(self.people)
				} catch let error as NSError {
					print(error)
				}
			}
			
			}.resume()
		print(self.people.count)
		self.tableView.reloadData()

	}
	
	
	
//	
//	func connection(didReceiveResponse: NSURLConnection!, didReceiveResponse response: URLResponse!) {
//		// Received a new request, clear out the data object
//		self.data = NSMutableData()
//	}
//	
//	func connection(connection: NSURLConnection!, didReceiveData data: NSData!) {
//		// Append the received chunk of data to our data object
//		self.data.append(data as Data)
//	}
//	
//	func connectionDidFinishLoading(connection: NSURLConnection!) {
//		// Request complete, self.data should now hold the resulting info
//		// Convert the retrieved data in to an object through JSON deserialization
//		
//		do {
//			if let jsonResult = try JSONSerialization.jsonObject(with: data as Data, options: .allowFragments) as? [String:AnyObject] {
//				print(jsonResult)
//			}
//		} catch let error as NSError {
//			print(error.localizedDescription)
//		}
//
//		
////		guard let jsonResult: NSDictionary = JSONSerialization.jsonObject(with: data as Data, options: JSONSerialization.ReadingOptions.mutableContainers) as? NSDictionary else {
////			throw MyError.RuntimeError("Fuck")
////		}
//		
//		//NSLog("%@", jsonDict);
//
//	}
}
