CREATE DATABASE  IF NOT EXISTS `db-ovisys` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db-ovisys`;


DROP TABLE IF EXISTS `faqs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `faqs_category_id` int NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_faqs_faqs_categories1_idx` (`faqs_category_id`),
  CONSTRAINT `fk_faqs_faqs_categories1` FOREIGN KEY (`faqs_category_id`) REFERENCES `faqs_categories` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs`
--

LOCK TABLES `faqs` WRITE;
/*!40000 ALTER TABLE `faqs` DISABLE KEYS */;
INSERT INTO `faqs` VALUES (1,1,'Como faço para acompanhar o status do meu pedido?','Acesse a área \"Meus Pedidos\" no seu perfil e clique sobre o número do pedido para ver o status detalhado.'),(2,1,'Posso cancelar um pedido após a confirmação?','Pedidos podem ser cancelados em até 1 hora após a confirmação, desde que ainda não tenham sido separados para envio.'),(3,1,'É possível alterar o endereço de entrega após o pedido?','Sim, contate nosso suporte em até 2 horas após a compra com o número do pedido e o novo endereço.'),(4,2,'Quais formas de pagamento são aceitas?','Aceitamos cartão de crédito (Visa, Mastercard, Elo), boleto bancário e Pix.'),(5,2,'Em quantas parcelas posso parcelar minha compra?','Compras com cartão de crédito podem ser parceladas em até 12 vezes sem juros para pedidos acima de R$ 200,00.'),(6,2,'Meu pagamento foi recusado. O que fazer?','Verifique os dados do cartão e o limite disponível. Se o problema persistir, tente outra forma de pagamento ou entre em contato com seu banco.'),(7,2,'O boleto venceu. Posso gerar um novo?','Sim. Acesse \"Meus Pedidos\", localize o pedido em questão e clique em \"Gerar novo boleto\". O prazo de pagamento será de 1 dia útil.'),(8,3,'Qual o prazo de entrega?','O prazo varia conforme a região e o produto. Após a confirmação do pagamento, o prazo estimado é exibido no resumo do pedido.'),(9,3,'Meu pedido está atrasado. O que fazer?','Se o prazo estimado já passou, acesse \"Meus Pedidos\" e clique em \"Falar com suporte\" para abrir um chamado de rastreamento.'),(10,3,'Posso retirar meu pedido na loja?','Sim. Selecione a opção \"Retirar na loja\" durante o checkout e aguarde o e-mail de confirmação de disponibilidade.'),(11,4,'Como solicito a troca de um produto?','Acesse \"Meus Pedidos\", selecione o produto e clique em \"Solicitar troca\". O prazo para solicitação é de até 7 dias após o recebimento.'),(12,4,'Qual o prazo para devolução?','De acordo com o Código de Defesa do Consumidor, você tem até 7 dias corridos após o recebimento para desistir da compra.'),(13,4,'Quem paga o frete da devolução?','Caso o produto apresente defeito, o frete de devolução é por nossa conta. Em caso de desistência, o frete é de responsabilidade do cliente.'),(14,5,'Como altero minha senha?','Acesse \"Minha Conta\" > \"Segurança\" > \"Alterar senha\". Você receberá um e-mail de confirmação para concluir a alteração.'),(15,5,'Esqueci minha senha. Como recuperá-la?','Na tela de login, clique em \"Esqueci minha senha\" e informe o e-mail cadastrado. Você receberá um link de redefinição em até 5 minutos.');
/*!40000 ALTER TABLE `faqs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `faqs_categories`
--




DROP TABLE IF EXISTS `faqs_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `faqs_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `faqs_categories`
--

LOCK TABLES `faqs_categories` WRITE;
/*!40000 ALTER TABLE `faqs_categories` DISABLE KEYS */;
INSERT INTO `faqs_categories` VALUES (1,'Pedidos'),(2,'Pagamentos'),(3,'Entregas'),(4,'Devoluções e Trocas'),(5,'Cadastro e Conta');
/*!40000 ALTER TABLE `faqs_categories` ENABLE KEYS */;
UNLOCK TABLES;