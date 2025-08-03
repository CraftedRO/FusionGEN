<div class="page-subbody mt-0 p-3">
    <form onSubmit="Search.show_data(); return false;">
        <div class="input-group">
            <input class="col-xs-12 col-sm-12 col-md-12 col-lg-3 form-control mx-1 mt-3" type="text" id="search_field" name="search_field" placeholder="{lang("search_placeholder", "armory")}">

            <select class="col-xs-12 col-sm-12 col-md-12 col-lg-3 mx-1 mt-3" id="realm" name="realm">
                <option value="0" disabled>{lang("realm", "armory")}</option>
                {for $i = 0; $i<count((array)$realms); $i++}
                    <option {if $i == 0}selected{/if} value="{$realms[$i]->getId()}">{$realms[$i]->getName()}</option>
                {/for}
            </select>

            <select class="col-xs-12 col-sm-12 col-md-12 col-lg-3 mx-1 mt-3" id="table" name="table">
                <option value="characters">{lang("characters", "armory")}</option>
                <option value="guilds">{lang("guilds", "armory")}</option>
                <option value="items">{lang("items", "armory")}</option>
            </select>

            <button class="nice_button rounded mx-1 mt-3" type="submit"><i class="fas fa-magnifying-glass"></i> {lang("search_button", "armory")}</button>
        </div>
    </form>
</div>

<div class="page-subbody mt-3 p-3 table-responsive" id="search_box">
	<table class="nice_table" id="search_results_items">
        <thead>
            <tr>
				<th>{lang("name", "armory")}</th>
				<th>{lang("level", "armory")}</th>
				<th>{lang("required", "armory")}</th>
				<th>{lang("type", "armory")}</th>
			</tr>
        </thead>
        <tbody></tbody>
    </table>
    <table class="nice_table" id="search_results_characters">
        <thead>
            <tr>
				<th></th>
				<th>{lang("name", "armory")}</th>
				<th>{lang("faction", "armory")}</th>
				<th>{lang("level", "armory")}</th>
				<th></th>
			</tr>
        </thead>
        <tbody></tbody>
    </table>
    <table class="nice_table" id="search_results_guilds">
        <thead>
            <tr>
				<th>{lang("name", "armory")}</th>
				<th>{lang("members", "armory")}</th>
				<th>{lang("owner", "armory")}</th>
			</tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
