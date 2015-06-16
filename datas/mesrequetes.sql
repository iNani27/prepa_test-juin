/* requete de connexion */
SELECT u.id, u.lemail, u.lenom, 
		d.lenom AS nom_perm, d.ladesc, d.laperm
	FROM utilisateur u 
	INNER JOIN droit d ON u.droit_id=d.id
    WHERE u.lelogin="Admin" AND u.lemdp="admin"
    ;