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

class FeedViewController: UITableViewController {
    
    
    override func tableView(_ tableView: UITableView, cellForRowAt indexPath: IndexPath) -> UITableViewCell {
        let cell = tableView.dequeueReusableCell(withIdentifier: "LabelCell", for: indexPath) as! FeedCell
        
        
        
        return cell
    }
    
    func processJSON(){
        var names = [String]()
        
        do {
            let json = try NSJSONSerialization.JSONObjectWithData(data, options: .AllowFragments)
            
            if let blogs = json["blogs"] as? [[String: AnyObject]] {
                for blog in blogs {
                    if let name = blog["name"] as? String {
                        names.append(name)
                    }
                }
            }
        } catch {
            print("error serializing JSON: \(error)")
        }
        
        print(names) // ["Bloxus test", "Manila Test"]
    }
}
