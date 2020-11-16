# Как Magento загружает файлы конфигурации

### Порядок загрузки конфиг-файлов 
Magento загружает файлы конфигурации в следующем порядке (все пути указаны относительно каталога установки Magento):
<ol>
<li>Первичная конфигурация (приложение / etc / di.xml). Этот файл используется для начальной загрузки Magento.</li>
<li>
Глобальные конфигурации из модулей (vendor/module/etc/*.xml). 
Собирает определенные файлы конфигурации из всех модулей и объединяет их вместе.
</li>
<li>
Конфигурация для конкретной области из модулей (vendor/module/etc/area_code/*.xml). Например, из директорий vendor/module/etc/frontend/*.xml, vendor/module/etc/adminhtml/*.xml.
Magento собирает файлы конфигурации из всех модулей и объединяет их в глобальную конфигурацию. 
Некоторые специфические для области конфигурации могут отменять или расширять глобальную конфигурацию.
</ol>

### Слияние файлов конфигурации
Узлы в файлах конфигурации объединяются на основе их полностью определенных XPath, для которых есть специальный атрибут,
определенный в массиве $idAttributes, объявленный как его идентификатор. 
Этот идентификатор должен быть уникальным для всех узлов, вложенных в один родительский узел.

##### Алгоритм слияния Magento следующий:
<ol>
<li>
Если идентификаторы узлов равны (или если идентификатор не определен), все базовое содержимое в узле 
(атрибуты, дочерние узлы и скалярное содержимое) переопределяется.
</li>
<li>
Если идентификаторы узлов не равны, узел является новым дочерним элементом родительского узла.
</li>
<li>
Если исходный документ имеет несколько узлов с одним и тем же идентификатором, возникает ошибка, 
поскольку идентификаторы невозможно различить.
После объединения файлов конфигурации полученный документ содержит все узлы из исходных файлов.
</li>
</ol>


### Типы и объекты конфигурации
В следующей таблице показаны каждый тип конфигурации и объект конфигурации Magento, к которому он относится.

<table>
  <thead>
    <tr>
      <th>Конфигурационный файл</th>
      <th>Описание</th>
      <th>Уровни</th>
      <th>Объекты-резолверы конфигураций</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">address_formats.xml</code></td>
      <td>Формат адреса</td>
      <td>primary, global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Customer/Model/Address/Config.php">\Magento\Customer\Model\Address\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">acl.xml</code></td>
      <td><a href="/guides/v2.4/get-started/authentication/gs-authentication.html#relationship-between-aclxml-and-webapixml">Access Control List</a></td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/Acl/AclResource/Provider.php">\Magento\Framework\Acl\AclResource\Provider</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">analytics.xml</code></td>
      <td><a href="/guides/v2.4/advanced-reporting/data-collection.html">Репортинг</a></td>
      <td>primary, global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Analytics/Model/Config/Reader.php">\Magento\Analytics\Model\Config\Reader</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">cache.xml</code></td>
      <td>Типы кэшей</td>
      <td>primary, global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/Cache/Config/Data.php">\Magento\Framework\Cache\Config\Data</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">catalog_attributes.xml</code></td>
      <td>Каталог-аттрибуты</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Catalog/Model/Attribute/Config/Data.php">\Magento\Catalog\Model\Attribute\Config\Data</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">config.php</code> and <code class="language-plaintext highlighter-rouge">env.php</code></td>
      <td><a href="/guides/v2.4/config-guide/config/config-php.html">Деплоймент конфигурация</a></td>
      <td>These files are readable/writeable by the internal config processor.</td>
      <td>Has no object, cannot be customized</td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">config.xml</code></td>
      <td>Конфигурация системы</td>
      <td>primary, global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/App/Config.php">\Magento\Framework\App\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">communication.xml</code></td>
      <td><a href="/guides/v2.4/extension-dev-guide/message-queues/config-mq.html#communicationxml">Defines aspects of the message queue system</a></td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/WebapiAsync/Code/Generator/Config/RemoteServiceReader/Communication.php">\Magento\WebapiAsync\Code\Generator\Config\RemoteServiceReader\Communication</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">crontab.xml</code></td>
      <td><a href="/guides/v2.4/config-guide/cron/custom-cron-ref.html#config-cli-cron-group-conf">Configures cron groups</a></td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Cron/Model/Config/Data.php">\Magento\Cron\Model\Config\Data</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">cron_groups.xml</code></td>
      <td><a href="/guides/v2.4/config-guide/cron/custom-cron-ref.html">Specifies cron group options</a></td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Cron/Model/Groups/Config/Data.php">\Magento\Cron\Model\Groups\Config\Data</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">db_schema.xml</code></td>
      <td><a href="/guides/v2.4/extension-dev-guide/declarative-schema/db-schema.html">Declarative schema</a></td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/Setup/Declaration/Schema/SchemaConfig.php">Magento\Framework\Setup\Declaration\Schema</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">di.xml</code></td>
      <td><a href="/guides/v2.4/extension-dev-guide/depend-inj.html">Dependency injection</a> configuration</td>
      <td>primary, global, area</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/ObjectManager/Config/Config.php">\Magento\Framework\ObjectManager\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">eav_attributes.xml</code></td>
      <td>Provides EAV attributes configuration</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Eav/Model/Entity/Attribute/Config.php">\Magento\Eav\Model\Entity\Attribute\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">email_templates.xml</code></td>
      <td>Email templates configuration</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Email/Model/Template/Config/Data.php">\Magento\Email\Model\Template\Config\Data</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">esconfig.xml</code></td>
      <td><a href="/guides/v2.4/config-guide/elasticsearch/es-config-stopwords.html#config-create-stopwords">Elasticsearch locale stopwords config</a></td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Elasticsearch/Model/Adapter/Index/Config/EsConfig.php">\Magento\Elasticsearch\Model\Adapter\Index\Config\EsConfig</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">events.xml</code></td>
      <td>Event/observer configuration</td>
      <td>global, area</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/Event.php">\Magento\Framework\Event</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">export.xml</code></td>
      <td>Export entity configuration</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/ImportExport/Model/Export/Config.php">\Magento\ImportExport\Model\Export\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">extension_attributes.xml</code></td>
      <td><a href="/guides/v2.4/extension-dev-guide/attributes.html#extension">Extension attributes</a></td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/Api/ExtensionAttribute/Config.php">\Magento\Framework\Api\ExtensionAttribute\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">fieldset.xml</code></td>
      <td>Defines fieldsets</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/DataObject/Copy/Config/Reader.php">\Magento\Framework\DataObject\Copy\Config\Reader</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">indexer.xml</code></td>
      <td><a href="/guides/v2.4/extension-dev-guide/indexing-custom.html">Declares indexers</a></td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/Indexer/Config/Reader.php">\Magento\Framework\Indexer\Config\Reader</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">import.xml</code></td>
      <td>Declares import entities</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/ImportExport/Model/Import/Config.php">\Magento\ImportExport\Model\Import\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">menu.xml</code></td>
      <td>Defines menu items for admin panel</td>
      <td>adminhtml</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Backend/Model/Menu/Config/Reader.php">\Magento\Backend\Model\Menu\Config\Reader</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">module.xml</code></td>
      <td>Defines module config data and soft dependency</td>
      <td>primary, global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/Module/ModuleList/Loader.php">\Magento\Framework\Module\ModuleList\Loader</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">mview.xml</code></td>
      <td><a href="/guides/v2.4/extension-dev-guide/indexing-custom.html#mview-configuration">MView configuration</a></td>
      <td>primary, global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/Mview/Config/Data.php">\Magento\Framework\Mview\Config\Data</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">payment.xml</code></td>
      <td>Payment module configuration</td>
      <td>primary, global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Payment/Model/Config.php">\Magento\Payment\Model\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">persistent.xml</code></td>
      <td><a href="/guides/v2.4/mrg/ce/Persistent.html">Magento_Persistent</a> configuration file</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Persistent/Helper/Data.php">\Magento\Persistent\Helper\Data</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">pdf.xml</code></td>
      <td>PDF settings</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Sales/Model/Order/Pdf/Config/Reader.php">\Magento\Sales\Model\Order\Pdf\Config\Reader</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">product_options.xml</code></td>
      <td>Provides product options configuration</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Catalog/Model/ProductOptions/Config.php">\Magento\Catalog\Model\ProductOptions\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">product_types.xml</code></td>
      <td>Defines product type</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Catalog/Model/ProductTypes/Config.php">\Magento\Catalog\Model\ProductTypes\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">queue_consumer.xml</code></td>
      <td><a href="/guides/v2.4/extension-dev-guide/message-queues/config-mq.html#queueconsumerxml">Defines the relationship between an existing queue and its consumer</a></td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/MessageQueue/Consumer/Config/Xml/Reader.php">\Magento\Framework\MessageQueue\Consumer\Config\Xml\Reader</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">queue_publisher.xml</code></td>
      <td><a href="/guides/v2.4/extension-dev-guide/message-queues/config-mq.html#queuepublisherxml">Defines the exchange where a topic is published.</a></td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/WebapiAsync/Code/Generator/Config/RemoteServiceReader/Publisher.php">\Magento\WebapiAsync\Code\Generator\Config\RemoteServiceReader\Publisher</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">queue_topology.xml</code></td>
      <td><a href="/guides/v2.4/extension-dev-guide/message-queues/config-mq.html#queuetopologyxml">Defines the message routing rules, declares queues and exchanges</a></td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/MessageQueue/Topology/Config/Xml/Reader.php">\Magento\Framework\MessageQueue\Topology\Config\Xml\Reader</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">reports.xml</code></td>
      <td><a href="/guides/v2.4/advanced-reporting/report-xml.html">Advanced reports</a></td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Analytics/ReportXml/Config.php">\Magento\Analytics\ReportXml\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">resources.xml</code></td>
      <td>Defines module resource</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/App/ResourceConnection/Config/Reader.php">\Magento\Framework\App\ResourceConnection\Config\Reader</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">routes.xml</code></td>
      <td><a href="/guides/v2.4/extension-dev-guide/routing.html">Route</a> configuration</td>
      <td>area</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/App/Route/Config.php">Magento\Framework\App\Route\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">sales.xml</code></td>
      <td>Defines sales total configuration</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Sales/Model/Config/Data.php">\Magento\Sales\Model\Config\Data</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">search_engine.xml</code></td>
      <td>Provides search engine configuration</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Search/Model/SearchEngine/Config.php">Magento\Search\Model\SearchEngine\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">search_request.xml</code></td>
      <td>Defines catalog search configuration</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/Search/Request/Config.php">\Magento\Framework\Search\Request\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">sections.xml</code></td>
      <td>Defines actions that trigger cache invalidation for private content blocks</td>
      <td>frontend</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Customer/etc/di.xml#L137-L148">SectionInvalidationConfigReader</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">system.xml</code></td>
      <td>Defines options for system configuration page</td>
      <td>adminhtml</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/App/Config.php">\Magento\Framework\App\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">validation.xml</code></td>
      <td>Module validation configuration file</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/Validator/Factory.php">\Magento\Framework\Validator\Factory</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">view.xml</code></td>
      <td>Defines Vendor_Module view config values</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/lib/internal/Magento/Framework/View/Config.php">\Magento\Framework\View\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">webapi.xml</code></td>
      <td><a href="/guides/v2.4/extension-dev-guide/service-contracts/service-to-web-service.html">Configures a web API</a></td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Webapi/Model/Config.php">\Magento\Webapi\Model\Config</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">webapi_async.xml</code></td>
      <td><a href="/guides/v2.4/extension-dev-guide/webapi/custom-routes.html">Defines REST custom routes</a></td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/WebapiAsync/Model/ServiceConfig.php">\Magento\WebapiAsync\Model\ServiceConfig</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">widget.xml</code></td>
      <td>Defines widgets</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Widget/Model/Config/Reader.php">\Magento\Widget\Model\Config\Reader</a></td>
    </tr>
    <tr>
      <td><code class="language-plaintext highlighter-rouge">zip_codes.xml</code></td>
      <td>Defines zip code format for each country</td>
      <td>global</td>
      <td><a href="https://github.com/magento/magento2/blob/2.4/app/code/Magento/Directory/Model/Country/Postcode/Config/Data.php">\Magento\Directory\Model\Country\Postcode\Config\Data</a></td>
    </tr>
  </tbody>
</table>