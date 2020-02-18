<?php

class BankView extends View
{
    public function index()
    {
        $mysidia = Registry::get("mysidia");
        $sitename = $mysidia->db->select("settings", array("value"), "name = 'sitename'")->fetchColumn();
        $document = $this->document;
        $document->add(new Comment("<title>{$sitename} | Bank</title>"));
        $document->setTitle("The Bank");
        $balance = $mysidia->user->bank;
        $cash = $mysidia->user->getcash();

        if ($balance == 0 || $balance == null) {
            $document->add(new Comment("<h2>Current Balance: $0</h2>"));
        } else {
            $document->add(new Comment("<h2>Current Balance: $ {$balance}</h2>", false));
        }
    
        $document->add(new paragraph);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $choice = $_REQUEST['submitbutton'];
            $amount = $_REQUEST['amount'];
            switch ($choice) {
                case "deposit":
                    if ($amount > $cash) {
                        $document->add(new Comment("You don't have that much to deposit!", true));
                        $document->add(new Comment("<a href='{$home}bank'>Return to Bank</a>", false));
                        return;
                    } else {
                        $mysidia->db->update_increase("users", array("bank"), $amount, "username = '{$mysidia->user->username}'");
                        $mysidia->db->update_decrease("users", array("money"), $amount, "username = '{$mysidia->user->username}'");
                        $document->add(new Comment("You deposited $ {$amount} into your bank account.", true));
                        $document->add(new Comment("<a href='{$home}bank'>Return to Bank?</a>", false));
                        return;
                    }
                    break;
                case "withdraw":
                    if ($amount > $balance) {
                        $document->add(new Comment("You don't have that much to withdraw!", true));
                        $document->add(new Comment("<a href='{$home}bank'>Return to Bank</a>", false));
                        return;
                    } else {
                        $mysidia->db->update_increase("users", array("money"), $amount, "username = '{$mysidia->user->username}'");
                        $mysidia->db->update_decrease("users", array("bank"), $amount, "username = '{$mysidia->user->username}'");
                        $document->add(new Comment("You withdrew $ {$amount} from your bank account.", true));
                        $document->add(new Comment("<a href='{$home}bank'>Return to Bank?</a>", false));
                        return;
                    }
                    break;
            }
        }
        
        $document->add(new Comment("
			<div class='row'>
				<div class='col-sm-6'>
					<div class='card'>
						<div class='card-body'>
							<h5 class='card-title'>Deposit</h5>
							<p class='card-text'>Add money into the bank, so you can save it for later.</p>
							<form class='form' action='bank' method='post'>
								<input type='number' min='1' class='form-control' name='amount' id='amount' placeholder='Amount' required></br>
								<button type='submit' name='submitbutton' value='deposit' class='btn btn-primary mb-2'>Deposit</button>
							</form>
						</div>
					</div>
				</div>
				<div class='col-sm-6'>
					<div class='card'>
						<div class='card-body'>
							<h5 class='card-title'>Withdraw</h5>
							<p class='card-text'>Take money out of the bank, so you can use it on the site!</p>
							<form class='form' action='bank' method='post'>
								<input type='number' min='1' class='form-control' name='amount' id='amount' placeholder='Amount' required></br>
								<button type='submit' name='submitbutton' value='withdraw' class='btn btn-primary mb-2'>Withdraw</button>
							</form>
						</div>
					</div>
				</div>
			</div>"));
    }
}
