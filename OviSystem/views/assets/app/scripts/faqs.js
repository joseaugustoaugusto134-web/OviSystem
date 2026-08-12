async function fetchFAQs()
{
  const response = await fetch("http://localhost/OviSystem/api/faqs-categories/list");
  console.log(response);
  const faqs = await response.json();
  console.log(faqs.data);
  const listFaqs = document.querySelector("#list-faqs");
}
fetchFAQs();